<?php
declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Exceptions\UserTypeNotFoundException;
use ConversationBundle\Entity\Conversation;
use ConversationBundle\Entity\Message;
use ConversationBundle\Exceptions\ConversationForRecipientNotFoundException;
use ConversationBundle\Exceptions\ConversationNotFoundException;
use ConversationBundle\Exceptions\NoColleagueException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use ConversationBundle\Service\Conversation\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="ConversationBundle\Controller\ConversationController")
 */
class ConversationController extends BaseController
{
    /**
     * @Route("/conversation" , name="conversation")
     * @param Request $httpRequest
     *
     * @return HttpResponse
     * @throws Throwable
     */
    public function requestHandler(Request $httpRequest)
    {
        try {
            list($method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(string $method, array $parameters = [])
    {
        if (is_callable([$this, $method])) {
            return $this->$method($parameters);
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
        $this->checkParameters([
            'id',
        ], $parameters);

        return Mapper::fromConversation($this->conversationService->getConversation((int)$parameters['id']));
    }

    /**
     * @return array
     */
    private function getConversations()
    {
        return Mapper::fromConversations(...$this->conversationService->getConversations($this->user));
    }

    /**
     * @param array $parameters
     *
     * @return array $conversation
     * @throws NoColleagueException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function createConversation(array $parameters)
    {
        $this->checkParameters([
            'recipient_id',
            'message',
        ], $parameters);

        $recipient = $this->userService->getUser((int)$parameters['recipient_id']);
        $userType  = $this->userTypeService->getUserType(3);
        $agentIds  = $this->agentService->getAgentIdsFromGroup($this->user->getAgent());

        if (!$this->userService->isColleague($recipient->getId(), $agentIds, $userType)) {
            throw new NoColleagueException((int)$parameters['recipient_id']);
        }

        $conversation = $this->conversationService->findByUsers($this->user, $recipient);

        if (empty($conversation)) {
            $conversation = new Conversation();
            $conversation->setAuthor($this->user);
            $conversation->setRecipient($recipient);
            $conversation->setUniqueId($this->user->getId() + $recipient->getId());
            $conversation = $this->conversationService->createConversation($conversation);
        }

        $message = new Message();

        $message->setConversation($conversation);
        $message->setAuthor($this->user);
        $message->setRecipient($recipient);
        $message->setMessage($parameters['message']);
        if (array_key_exists('type', $parameters) && $parameters['type'] !== null) {
            $message->setType($parameters['type']);
        }

        $this->messageService->createMessage($message);

        return Mapper::fromConversation($conversation);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws ConversationNotFoundException
     */
    private function getMessages(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $conversation = $this->conversationService->getConversation((int)$parameters['id']);

        $messages = $this->messageService->getMessages($conversation);

        foreach ($messages as $message) {
            if (!$message->getSeen() && $message->getRecipient()->getId() === $this->user->getId()) {
                $this->messageService->readMessage($message);
            }
        }

        return Mapper::fromMessages(...$messages);
    }


    /**
     * @param array $parameters
     *
     * @return array
     * @throws ConversationForRecipientNotFoundException
     * @throws UserNotFoundException
     */
    private function getConversationByRecipient(array $parameters)
    {
        $this->checkParameters([
            'recipient_id',
        ], $parameters);

        $recipient    = $this->userService->getUser((int)$parameters['recipient_id']);
        $conversation = $this->conversationService->findByUsers($this->user, $recipient);

        if ($conversation === null) {
            throw new ConversationForRecipientNotFoundException();
        }

        $messages = $this->messageService->getMessages($conversation);

        foreach ($messages as $message) {
            if (!$message->getSeen() && $message->getRecipient()->getId() === $this->user->getId()) {
                $this->messageService->readMessage($message);
            }
        }

        return Mapper::fromMessages(...$messages);
    }

    /**
     * @return array $messages
     */
    private function getUnread()
    {
        return Mapper::fromMessages(...$this->messageService->getUnread($this->user));
    }
}
