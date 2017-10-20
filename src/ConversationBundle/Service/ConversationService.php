<?php declare(strict_types=1);

namespace ConversationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use ConversationBundle\Entity\Conversation;

/**
 * @package ConversationBundle\Service
 */
class ConversationService
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
     * @return Conversation $conversation
     */
    public function getConversation(int $id)
    {
        $repository   = $this->entityManager->getRepository('ConversationBundle:Conversation');
        $conversation = $repository->findById($id);

        return $conversation;
    }

    /**
     * @return Conversation[]
     */
    public function getConversations()
    {
        $repository = $this->entityManager->getRepository('ConversationBundle:Conversation');

        return $repository->listAll();
    }

    /**
     * @param int $user
     *
     * @return Conversation
     */
    public function findByUser(int $user)
    {
        $repository   = $this->entityManager->getRepository('ConversationBundle:Conversation');
        $conversation = $repository->findByUser($user);


        return $conversation;
    }

    /**
     * @param int $fromUser
     * @param int $toUser
     *
     * @return Conversation
     */
    public function findByUsers(int $fromUser, int $toUser)
    {
        $repository   = $this->entityManager->getRepository('ConversationBundle:Conversation');
        $conversation = $repository->findByUsers($fromUser, $toUser);


        return $conversation;
    }

    /**
     * @param Conversation $conversation
     *
     * @return Conversation
     */
    public function createConversation(Conversation $conversation)
    {
        $this->entityManager->persist($conversation);
        $this->entityManager->flush();

        return $conversation;
    }

    /**
     * @param Conversation $conversation
     *
     * @return Conversation
     */
    public function updateConversation(Conversation $conversation)
    {
        $this->entityManager->flush();

        return $conversation;
    }

    /**
     * @param int $id
     */
    public function closeConversation(int $id)
    {
        $conversationRepository = $this->entityManager->getRepository('ConversationBundle:Conversation');
        $conversation           = $conversationRepository->findById($id);

        $conversation->setClosed(true);

        $this->entityManager->flush();
    }
}
