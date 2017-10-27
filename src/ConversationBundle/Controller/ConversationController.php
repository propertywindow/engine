<?php declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use ConversationBundle\Entity\Conversation;
use ConversationBundle\Entity\Message;
use ConversationBundle\Exceptions\ConversationNotFoundException;
use ConversationBundle\Exceptions\NoColleagueException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use ConversationBundle\Service\Conversation\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

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
        try {
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable);
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
                return $this->getConversations($userId);
            case "createConversation":
                return $this->createConversation($userId, $parameters);
            case "getMessages":
                return $this->getMessages($userId, $parameters);
            case "getUnread":
                return $this->getUnread($userId);
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
     * @param int $userId
     *
     * @return array
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function getConversations(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromConversations(...$this->conversationService->getConversations($user));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $conversation
     *
     * @throws NoColleagueException
     */
    private function createConversation(int $userId, array $parameters)
    {
        if (!array_key_exists('to_user_id', $parameters) && $parameters['to_user_id'] !== null) {
            throw new InvalidArgumentException("to_user_id parameter not provided");
        }
        if (!array_key_exists('message', $parameters) && $parameters['message'] !== null) {
            throw new InvalidArgumentException("message parameter not provided");
        }

        $fromUser = $this->userService->getUser($userId);
        $toUser   = $this->userService->getUser((int)$parameters['to_user_id']);
        $userType = $this->userTypeService->getUserType(3);
        $agentIds = $this->agentService->getAgentIdsFromGroup((int)$fromUser->getAgent()->getId());

        if (!$this->userService->isColleague($toUser->getId(), $agentIds, $userType)) {
            throw new NoColleagueException((int)$parameters['to_user_id']);
        }

        $conversation = $this->conversationService->findByUsers($fromUser, $toUser);

        if (empty($conversation)) {
            $conversation = new Conversation();
            $conversation->setFromUser($fromUser);
            $conversation->setToUser($toUser);
            $conversation->setUniqueId($fromUser->getId() + $toUser->getId());
            $conversation = $this->conversationService->createConversation($conversation);
        }

        $message = new Message();

        $message->setConversation($conversation);
        $message->setFromUser($fromUser);
        $message->setToUser($toUser);
        $message->setMessage($parameters['message']);

        $this->messageService->createMessage($message);

        return Mapper::fromConversation($conversation);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws ConversationNotFoundException
     */
    private function getMessages(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id           = (int)$parameters['id'];
        $conversation = $this->conversationService->getConversation($id);

        $messages = $this->messageService->getMessages($conversation);

        foreach ($messages as $message) {
            if (!$message->getSeen() && $message->getToUser()->getId() === $userId) {
                $this->messageService->readMessage($message);
            }
        }

        return Mapper::fromMessages(...$messages);
    }

    /**
     * @param int $userId
     *
     * @return array $messages
     */
    private function getUnread(int $userId)
    {
        $user     = $this->userService->getUser($userId);
        $messages = $this->messageService->getUnread($user);

        return Mapper::fromMessages(...$messages);
    }
}
