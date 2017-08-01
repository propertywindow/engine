<?php declare(strict_types=1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PropertyBundle\Entity\Property;
use PropertyBundle\Exceptions\PropertyNotFoundException;

/**
 * PropertyRepository
 *
 */
class PropertyRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Property
     * @throws PropertyNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): Property
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new PropertyNotFoundException($id);
        }

        /** @var Property $result */
        return $result;
    }


    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array First value Property[], second value the total count.
     * @throws \Doctrine\ORM\RuntimeException
     */
    public function listAll(?int $limit, ?int $offset): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('n')
                   ->from('PropertyBundle:Property', 'n');

        $qb->orderBy('n.id', 'DESC')
           ->setFirstResult($offset)
           ->setMaxResults($limit);

        $pages = new Paginator($qb);

        $count   = $pages->count();
        $results = $pages->getQuery()->getResult();

        return [
            $results,
            $count,
        ];
    }

    /**
     * @param int $userId
     *
     * @return Property[]
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\RuntimeException
     */
    public function findPropertiesForUser(int $userId): array
    {
        // todo: get agentId from userId

        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('p')
                   ->from('PropertyBundle:Property', 'p');

        $qb->where("p.agentId = :userId");
        $qb->orderBy('p.id', 'DESC');
        $qb->setParameter('userId', $userId);

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
