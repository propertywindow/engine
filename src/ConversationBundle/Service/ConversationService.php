<?php declare(strict_types=1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
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
     * @throws \ConversationBundle\Exceptions\ConversationNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getConversation(int $id)
    {
        $repository   = $this->entityManager->getRepository('ConversationBundle:Conversation');
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
        $repository = $this->entityManager->getRepository('ConversationBundle:Conversation');

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
        $repository   = $this->entityManager->getRepository('ConversationBundle:Conversation');
        $conversation = $repository->findOneBy(['uniqueId' => $author->getId() + $recipient->getId()]);

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
