<?php declare(strict_types=1);

namespace AgentBundle\Repository;

use AgentBundle\Entity\AgentGroup;
use AgentBundle\Exceptions\AgentGroupNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * AgentGroupRepository
 *
 */
class AgentGroupRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return AgentGroup
     * @throws AgentGroupNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): AgentGroup
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new AgentGroupNotFoundException($id);
        }

        /** @var AgentGroup $result */
        return $result;
    }
}
