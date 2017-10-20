<?php declare(strict_types=1);

namespace ConversationBundle\Service;

use ConversationBundle\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use ConversationBundle\Entity\Conversation;

/**
 * @package ConversationBundle\Service
 */
class MessageService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Message $conversation
     */
    public function getMessage(int $id)
    {
        $repository = $this->entityManager->getRepository('ConversationBundle:Message');
        $message    = $repository->findById($id);

        return $message;
    }

    /**
     * @param Conversation $conversation
     *
     * @return Message[]
     */
    public function getMessages(Conversation $conversation)
    {
        $repository = $this->entityManager->getRepository('ConversationBundle:Message');

        return $repository->listAll($conversation);
    }

    /**
     * @param Message $message
     *
     * @return Message
     */
    public function createMessage(Message $message)
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
    public function updateMessage(Message $message)
    {
        $this->entityManager->flush();

        return $message;
    }

    /**
     * @param int $id
     */
    public function readMessage(int $id)
    {
        $messageRepository = $this->entityManager->getRepository('ConversationBundle:Message');
        $message           = $messageRepository->findById($id);

        $message->setSeen(true);

        $this->entityManager->flush();
    }
}
