<?php
declare(strict_types=1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Repository\ConversationRepository;
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
     * @var ConversationRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Conversation::class);
    }

    /**
     * @param int $id
     *
     * @return Conversation
     * @throws \ConversationBundle\Exceptions\ConversationNotFoundException
     */
    public function getConversation(int $id): Conversation
    {
        return $this->repository->findById($id);
    }

    /**
     * @param User $user
     *
     * @return Conversation[]
     */
    public function getConversations(User $user): array
    {
        return $this->repository->findByUser($user);
    }

    /**
     * @param User $author
     * @param User $recipient
     *
     * @return null|Conversation
     */
    public function findByUsers(User $author, User $recipient)
    {
        $conversation = $this->repository->findOneBy(['uniqueId' => $author->getId() + $recipient->getId()]);

        /** @var Conversation $conversation */
        return $conversation;
    }

    /**
     * @param Conversation $conversation
     *
     * @return Conversation
     */
    public function createConversation(Conversation $conversation): Conversation
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
    public function updateConversation(Conversation $conversation): Conversation
    {
        $this->entityManager->flush();

        return $conversation;
    }
}
