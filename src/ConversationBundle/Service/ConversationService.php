<?php
declare(strict_types=1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ConversationBundle\Entity\Conversation;

/**
 * Conversation Service
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
     * @throws \ConversationBundle\Exceptions\ConversationNotFoundException
     */
    public function getConversation(int $id)
    {
        $repository   = $this->entityManager->getRepository(Conversation::class);
        $conversation = $repository->findById($id);

        return $conversation;
    }

    /**
     * @param User $user
     *
     * @return Conversation[]
     */
    public function getConversations(User $user)
    {
        $repository = $this->entityManager->getRepository(Conversation::class);

        return $repository->findByUser($user);
    }

    /**
     * @param User $author
     * @param User $recipient
     *
     * @return null|Conversation
     */
    public function findByUsers(User $author, User $recipient)
    {
        $repository   = $this->entityManager->getRepository(Conversation::class);
        $conversation = $repository->findOneBy(['uniqueId' => $author->getId() + $recipient->getId()]);

        /** @var Conversation $conversation */
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
}
