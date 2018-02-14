<?php declare(strict_types = 1);

namespace AlertBundle\Repository;

use AgentBundle\Entity\AgentGroup;
use Doctrine\ORM\EntityRepository;
use AlertBundle\Entity\Alert;
use AlertBundle\Exceptions\AlertNotFoundException;

/**
 * AlertRepository
 */
class AlertRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Alert
     * @throws AlertNotFoundException
     */
    public function findById(int $id): Alert
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new AlertNotFoundException($id);
        }

        /** @var Alert $result */
        return $result;
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return Alert[]
     */
    public function findByAgent(AgentGroup $agentGroup): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('a')
                   ->from('AlertBundle:Alert', 'a')
                   ->innerJoin('a.applicant', 'p')
                   ->where("p.agentGroup = :agentGroup")
                   ->setParameter('agentGroup', $agentGroup)
                   ->orderBy('a.created', 'DESC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
