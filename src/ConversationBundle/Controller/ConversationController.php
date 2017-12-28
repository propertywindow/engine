<?php declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use ConversationBundle\Entity\Conversation;
use ConversationBundle\Entity\Message;
use ConversationBundle\Exceptions\ConversationForRecipientNotFoundException;
use ConversationBundle\Exceptions\NoColleagueException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
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
     * @throws Throwable
     */
    public function requestHandler(Request $httpRequest)
    {
        try {
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
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
     * @throws NoColleagueException
     * @throws \ConversationBundle\Exceptions\ConversationNotFoundException
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
            case "getConversationByRecipient":
                return $this->getConversationByRecipient($userId, $parameters);
            case "getUnread":
                return $this->getUnread($userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws \ConversationBundle\Exceptions\ConversationNotFoundException
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
        if (!array_key_exists('recipient_id', $parameters) && $parameters['recipient_id'] !== null) {
            throw new InvalidArgumentException("recipient_id parameter not provided");
        }
        if (!array_key_exists('message', $parameters) && $parameters['message'] !== null) {
            throw new InvalidArgumentException("message parameter not provided");
        }

        $author    = $this->userService->getUser($userId);
        $recipient = $this->userService->getUser((int)$parameters['recipient_id']);
        $userType  = $this->userTypeService->getUserType(3);
        $agentIds  = $this->agentService->getAgentIdsFromGroup((int)$author->getAgent()->getId());

        if (!$this->userService->isColleague($recipient->getId(), $agentIds, $userType)) {
            throw new NoColleagueException((int)$parameters['recipient_id']);
        }

        $conversation = $this->conversationService->findByUsers($author, $recipient);

        if (empty($conversation)) {
            $conversation = new Conversation();
            $conversation->setAuthor($author);
            $conversation->setRecipient($recipient);
            $conversation->setUniqueId($author->getId() + $recipient->getId());
            $conversation = $this->conversationService->createConversation($conversation);
        }

        $message = new Message();

        $message->setConversation($conversation);
        $message->setAuthor($author);
        $message->setRecipient($recipient);
        $message->setMessage($parameters['message']);

        $this->messageService->createMessage($message);

        return Mapper::fromConversation($conversation);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws \ConversationBundle\Exceptions\ConversationNotFoundException
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
            if (!$message->getSeen() && $message->getRecipient()->getId() === $userId) {
                $this->messageService->readMessage($message);
            }
        }

        return Mapper::fromMessages(...$messages);
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws ConversationForRecipientNotFoundException
     */
    private function getConversationByRecipient(int $userId, array $parameters)
    {
        if (!array_key_exists('recipient_id', $parameters) && $parameters['recipient_id'] !== null) {
            throw new InvalidArgumentException("recipient_id parameter not provided");
        }

        $author       = $this->userService->getUser($userId);
        $recipient    = $this->userService->getUser((int)$parameters['recipient_id']);
        $conversation = $this->conversationService->findByUsers($author, $recipient);
        $messages     = $this->messageService->getMessages($conversation);

        foreach ($messages as $message) {
            if (!$message->getSeen() && $message->getRecipient()->getId() === $userId) {
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
