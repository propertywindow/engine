<?php
declare(strict_types=1);

namespace ConversationBundle\Repository;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Notification;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Notification Repository
 */
class NotificationRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Notification
     * @throws NotificationNotFoundException
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
     * @param User $user
     *
     * @return array|Notification[]
     */
    public function listAll(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('n')
                   ->from('ConversationBundle:Notification', 'n')
                   ->where('n.user = :user')
                   ->setParameter('user', $user);

        $qb->orderBy('n.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int $userId
     *
     * @return array|Notification[]
     */
    public function getByUserId(int $userId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $expr = $qb->expr();
        $qb->select('n')
           ->from('ConversationBundle:Notification', 'n')
           ->leftJoin('n.users', 'u', Join::WITH, 'u = :userId')
           ->where(
               $expr->andX(
                   $expr->orX(
                       $expr->eq('n.forEveryone', '1'),
                       $expr->isNotNull('u.id')
                   ),
                   $expr->lt('n.start', 'CURRENT_TIMESTAMP()'),
                   $expr->orX(
                       $expr->isNull('n.end'),
                       $expr->gt('n.end', 'CURRENT_TIMESTAMP()')
                   ),
                   $expr->eq('n.visible', '1')
               )
           )
           ->setParameter('userId', $userId);


        $query         = $qb;
        $notifications = $query->getQuery()->getResult();

        return $notifications;
    }
}
