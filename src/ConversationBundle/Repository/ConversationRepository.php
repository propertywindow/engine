<?php declare(strict_types=1);

namespace ConversationBundle\Repository;

use ConversationBundle\Entity\Conversation;
use ConversationBundle\Exceptions\ConversationNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * ConversationRepository
 */
class ConversationRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Conversation
     * @throws ConversationNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): Conversation
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ConversationNotFoundException($id);
        }

        /** @var Conversation $result */
        return $result;
    }

    /**
     * @return Conversation[]
     */
    public function listAll(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('t')
                   ->from('ConversationBundle:Conversation', 'n');

        $qb->orderBy('n.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int $user
     *
     * @return Conversation[]
     */
    public function findByUser(int $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('t')
                   ->from('ConversationBundle:Conversation', 'n')
                   ->where('n.fromUser = :user')
                   ->orWhere('n.toUser = :user')
                   ->setParameter('user', $user)
                   ->orderBy('n.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int $fromUser
     * @param int $toUser
     *
     * @return Conversation[]
     */
    public function findByUsers(int $fromUser, int $toUser): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('t')
                   ->from('ConversationBundle:Conversation', 'n')
                   ->where('n.fromUser = :fromUser')
                   ->andWhere("n.toUser = :toUser")
                   ->orWhere('n.fromUser = :toUser')
                   ->andWhere("n.toUser = :fromUser")
                   ->setParameter('fromUser', $fromUser)
                   ->setParameter('toUser', $toUser)
                   ->setMaxResults(1);

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
