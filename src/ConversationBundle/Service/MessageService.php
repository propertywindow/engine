<?php
declare(strict_types = 1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Message;
use ConversationBundle\Exceptions\MessageNotFoundException;
use ConversationBundle\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use ConversationBundle\Entity\Conversation;

/**
 * Message Service
 */
class MessageService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MessageRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Message::class);
    }

    /**
     * @param int $id
     *
     * @return Message
     * @throws MessageNotFoundException
     */
    public function getMessage(int $id): Message
    {
        return $this->repository->findById($id);
    }

    /**
     * @param Conversation $conversation
     *
     * @return Message[]
     */
    public function getMessages(Conversation $conversation): array
    {
        return $this->repository->listAll($conversation);
    }

    /**
     * @param Message $message
     *
     * @return Message
     */
    public function createMessage(Message $message): Message
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }

    /**
     * @param Message $message
     *
     * @return Message
     */
    public function updateMessage(Message $message): Message
    {
        $this->entityManager->flush();

        return $message;
    }

    /**
     * @param Message $message
     */
    public function readMessage(Message $message)
    {
        $message->setSeen(true);

        $this->entityManager->flush();
    }

    /**
     * @param User $user
     *
     * @return Message[]
     */
    public function getUnread(User $user): array
    {
        return $this->repository->findUnreadByUser($user);
    }
}
