<?php declare(strict_types=1);

namespace AuthenticationBundle\Repository;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\Blacklist;
use AuthenticationBundle\Exceptions\BlacklistNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * BlacklistRepository
 *
 */
class BlacklistRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Blacklist
     *
     * @throws BlacklistNotFoundException
     */
    public function findById(int $id): Blacklist
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new BlacklistNotFoundException($id);
        }

        /** @var Blacklist $result */
        return $result;
    }

    /**
     * @param Agent $agent
     *
     * @return Blacklist[]
     */
    public function listAll(Agent $agent): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('b')
                   ->from('AuthenticationBundle:Blacklist', 'b')
                   ->where("b.agent = :agent")
                   ->setParameter('agent', $agent)
                   ->orderBy('b.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
