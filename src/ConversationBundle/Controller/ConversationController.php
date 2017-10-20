<?php declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use ConversationBundle\Entity\Conversation;
use ConversationBundle\Entity\Message;
use ConversationBundle\Exceptions\ConversationNotFoundException;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use ConversationBundle\Service\Conversation\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="conversation_controller")
 */
class ConversationController extends BaseController
{
    /**
     * @Route("/conversation" , name="conversation")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     */
    public function requestHandler(Request $httpRequest)
    {
        $id = null;
        try {
            list($id, $userId, $method, $parameters) = $this->prepareRequest($httpRequest);

            $jsonRpcResponse = Response::success($id, $this->invoke($userId, $method, $parameters));
        } catch (CouldNotParseJsonRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::PARSE_ERROR, $ex->getMessage()));
        } catch (InvalidJsonRpcRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_REQUEST, $ex->getMessage()));
        } catch (InvalidJsonRpcMethodException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::METHOD_NOT_FOUND, $ex->getMessage()));
        } catch (InvalidArgumentException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_PARAMS, $ex->getMessage()));
        } catch (CouldNotAuthenticateUserException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::USER_NOT_AUTHENTICATED, $ex->getMessage()));
        } catch (ConversationNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::CONVERSATION_NOT_FOUND, $ex->getMessage()));
        } catch (Exception $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INTERNAL_ERROR, $ex->getMessage()));
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param int    $userId
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     * @throws NotificationNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getConversation":
                return $this->getConversation($parameters);
            case "getConversations":
                return $this->getConversations();
            case "createConversation":
                return $this->createConversation($userId, $parameters);
            case "closeNotification":
                return $this->closeNotification($parameters, $userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws ConversationNotFoundException
     */
    private function getConversation(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromConversation($this->conversationService->getConversation($id));
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function getConversations()
    {
        return Mapper::fromConversations(...$this->conversationService->getConversations());
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $conversation
     *
     * @throws NotAuthorizedException
     */
    private function createConversation(int $userId, array $parameters)
    {
        if (!array_key_exists('to_user_id', $parameters) && $parameters['to_user_id'] !== null) {
            throw new InvalidArgumentException("to_user_id parameter not provided");
        }
        if (!array_key_exists('message', $parameters) && $parameters['message'] !== null) {
            throw new InvalidArgumentException("message parameter not provided");
        }

        $fromUser     = $this->userService->getUser($userId);
        $toUser       = $this->userService->getUser((int)$parameters['to_user_id']);
        $conversation = $this->conversationService->findByUsers($fromUser, $toUser);

        // todo: fix this, always creates a new one

        if (empty($conversation)) {
            $conversation = new Conversation();
            $conversation->setFromUser($fromUser);
            $conversation->setToUser($toUser);
            $conversation = $this->conversationService->createConversation($conversation);
        }

        $message = new Message();

        $message->setConversation($conversation);
        $message->setFromUser($fromUser);
        $message->setToUser($toUser);
        $message->setMessage($parameters['message']);

        $this->messageService->updateMessage($message);

        $conversation->setClosed(false);

        return Mapper::fromConversation($this->conversationService->updateConversation($conversation));
    }

    /**
     * @param array $parameters
     *
     * @param int   $userId
     *
     * @throws NotAuthorizedException
     */
    private function closeNotification(array $parameters, int $userId)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if ($userId === 1) {
            // todo: check if userId is either from or to
            throw new NotAuthorizedException($userId);
        }

        $id = (int)$parameters['id'];

        $this->conversationService->closeConversation($id);
    }
}
