<?php declare(strict_types = 1);

namespace AuthenticationBundle\Repository;

use AuthenticationBundle\Entity\ServiceGroup;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * ServiceGroupRepository
 */
class ServiceGroupRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return ServiceGroup
     * @throws ServiceGroupNotFoundException
     */
    public function findById(int $id): ServiceGroup
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ServiceGroupNotFoundException($id);
        }

        /** @var ServiceGroup $result */
        return $result;
    }

    /**
     * @return ServiceGroup[]
     */
    public function listAll(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('s')
                   ->from('AuthenticationBundle:ServiceGroup', 's')
                   ->orderBy('s.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
