<?php declare(strict_types=1);

namespace AgentBundle\Repository;

use AgentBundle\Entity\Agent;
use AgentBundle\Exceptions\AgentNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * AgentRepository
 *
 */
class AgentRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Agent
     * @throws AgentNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
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
                   ->from('AgentBundle:Agent', 'a');

        $qb->where("a.archived = false")
           ->orderBy('a.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
