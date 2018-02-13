<?php
declare(strict_types=1);

namespace AgentBundle\Repository;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\AgentGroup;
use AgentBundle\Exceptions\AgentNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * Agent Repository
 */
class AgentRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Agent
     * @throws AgentNotFoundException
     */
    public function findById(int $id): Agent
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new AgentNotFoundException($id);
        }

        /** @var Agent $result */
        return $result;
    }

    /**
     * @return Agent[]
     */
    public function listAll(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('a')
                   ->from('AgentBundle:Agent', 'a')
                   ->where("a.archived = false")
                   ->orderBy('a.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return int[] $ids
     */
    public function getAgentIdsFromGroup(AgentGroup $agentGroup): array
    {
        $ids = [];
        $qb  = $this->getEntityManager()->createQueryBuilder()
                    ->select('a')
                    ->from('AgentBundle:Agent', 'a');

        $qb->where("a.agentGroup = :agentGroup")
           ->orderBy('a.id', 'DESC')
           ->setParameter('agentGroup', $agentGroup);

        $agents = $qb->getQuery()->getResult();

        foreach ($agents as $agent) {
            /** @var Agent $agent */
            $ids[] = $agent->getId();
        }

        return $ids;
    }
}
