<?php
declare(strict_types = 1);

namespace AgentBundle\Repository;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Solicitor;
use AgentBundle\Exceptions\SolicitorNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * Solicitor Repository
 */
class SolicitorRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Solicitor
     * @throws SolicitorNotFoundException
     */
    public function findById(int $id): Solicitor
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new SolicitorNotFoundException($id);
        }

        /** @var Solicitor $result */
        return $result;
    }

    /**
     * @param Agent $agent
     *
     * @return Solicitor[]
     */
    public function listAll(Agent $agent): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('s')
                   ->from('AgentBundle:Solicitor', 's')
                   ->where("s.agent = :agent")
                   ->orderBy('s.id', 'ASC')
                   ->setParameter('agent', $agent);


        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
