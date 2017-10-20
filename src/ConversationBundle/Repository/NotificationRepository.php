<?php declare(strict_types=1);

namespace ConversationBundle\Repository;

use ConversationBundle\Entity\Notification;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * NotificationRepository
 */
class NotificationRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Notification
     * @throws NotificationNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): Notification
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new NotificationNotFoundException($id);
        }

        /** @var Notification $result */
        return $result;
    }

    /**
     * @return Notification[]
     */
    public function listAll(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('t')
                   ->from('ConversationBundle:Notification', 'n');

        $qb->orderBy('n.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
