<?php
declare(strict_types = 1);

namespace PropertyBundle\Repository;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PropertyBundle\Entity\Property;
use PropertyBundle\Exceptions\PropertyNotFoundException;

/**
 * Property Repository
 */
class PropertyRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Property
     * @throws PropertyNotFoundException
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
     * @param Agent $agent
     *
     * @return Property[]
     */
    public function getProperties(Agent $agent): array
    {
        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from('PropertyBundle:Property', 'p')
            ->where('p.agent = :agent')
            ->orderBy('p.id', 'DESC')
            ->setParameter('agent', $agent);

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int[] $agentIds
     * @param int   $limit
     * @param int   $offset
     *
     * @return Property[]
     */
    public function getAllProperties($agentIds, int $limit = 500, int $offset = 0): array
    {
        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from('PropertyBundle:Property', 'p')
            ->where('p.agent IN (:agentIds)')
            ->andWhere('p.archived = false')
            ->orderBy('p.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('agentIds', $agentIds);

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int $subTypeId
     *
     * @return Property[]
     */
    public function findPropertiesWithSubType(int $subTypeId): array
    {
        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
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
