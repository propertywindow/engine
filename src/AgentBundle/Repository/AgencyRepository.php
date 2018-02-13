<?php
declare(strict_types = 1);

namespace AgentBundle\Repository;

use AgentBundle\Entity\Agency;
use AgentBundle\Entity\Agent;
use AgentBundle\Exceptions\AgencyNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * Agency Repository
 */
class AgencyRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Agency
     * @throws AgencyNotFoundException
     */
    public function findById(int $id): Agency
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new AgencyNotFoundException($id);
        }

        /** @var Agency $result */
        return $result;
    }

    /**
     * @param Agent $agent
     *
     * @return Agency[]
     */
    public function listAll(Agent $agent): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('a')
                   ->from('AgentBundle:Agency', 'a')
                   ->where("a.agent = :agent")
                   ->orderBy('a.id', 'ASC')
                   ->setParameter('agent', $agent);


        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
