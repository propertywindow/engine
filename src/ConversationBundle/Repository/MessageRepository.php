<?php declare(strict_types=1);

namespace ConversationBundle\Repository;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Conversation;
use ConversationBundle\Entity\Message;
use ConversationBundle\Exceptions\MessageNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * MessageRepository
 */
class MessageRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Message
     * @throws MessageNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): Message
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new MessageNotFoundException($id);
        }

        /** @var Message $result */
        return $result;
    }

    /**
     * @param Conversation $conversation
     *
     * @return Message[]
     */
    public function listAll(Conversation $conversation): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('m')
                   ->from('ConversationBundle:Message', 'm')
                   ->where('m.conversation = :conversation')
                   ->setParameter('conversation', $conversation)
                   ->orderBy('m.created', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param User $user
     *
     * @return Message[]
     */
    public function findUnreadByUser(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('m')
                   ->from('ConversationBundle:Message', 'm')
                   ->where('m.toUser = :user')
                   ->andWhere('m.seen = false')
                   ->setParameter('user', $user)
                   ->orderBy('m.created', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
