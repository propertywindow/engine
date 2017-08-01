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
     * @param int $userId
     *
     * @return Property[]
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function listProperties(int $userId): array
    {
        // todo: get agentId from userId

        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('p')
                   ->from('PropertyBundle:Property', 'p');

        $qb->where("p.agentId = :userId")
           ->orderBy('p.id', 'DESC')
           ->setParameter('userId', $userId);

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int      $userId
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array First value Property[], second value the total count.
     */
    public function listAllProperties($userId, ?int $limit, ?int $offset): array
    {
        // todo: get properties from all agentIds in AgentGroup

        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('p')
                   ->from('PropertyBundle:Property', 'p');

        $qb->where("p.agentId = :userId")
           ->orderBy('p.id', 'DESC')
           ->setFirstResult($offset)
           ->setMaxResults($limit)
           ->setParameter('userId', $userId);

        $pages = new Paginator($qb);

        $count   = $pages->count();
        $results = $pages->getQuery()->getResult();

        return [
            $results,
            $count,
        ];
    }

    /**
     * @param int $subTypeId
     *
     * @return Property[]
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function findPropertiesWithSubType(int $subTypeId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('p')
                   ->from('PropertyBundle:Property', 'p');

        $qb->where("p.subType = :subTypeId");
        $qb->andWhere("p.archived = false");
        $qb->orderBy('p.id', 'DESC');
        $qb->setParameter('subTypeId', $subTypeId);

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
