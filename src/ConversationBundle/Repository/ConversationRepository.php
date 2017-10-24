<?php declare(strict_types=1);

namespace ConversationBundle\Repository;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Conversation;
use ConversationBundle\Exceptions\ConversationNotFoundException;
use ConversationBundle\Service\ConversationService;
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
                   ->select('c')
                   ->from('ConversationBundle:Conversation', 'c');

        $qb->orderBy('c.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param User $user
     *
     * @return Conversation[]
     */
    public function findByUser(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('c')
                   ->from('ConversationBundle:Conversation', 'c')
                   ->where('c.fromUser = :user')
                   ->orWhere('c.toUser = :user')
                   ->setParameter('user', $user)
                   ->orderBy('c.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
