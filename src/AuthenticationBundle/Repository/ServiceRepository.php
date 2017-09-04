<?php declare(strict_types=1);

namespace AuthenticationBundle\Repository;

use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Entity\ServiceGroup;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 */
class ServiceRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Service
     *
     * @throws ServiceNotFoundException
     */
    public function findById(int $id): Service
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ServiceNotFoundException($id);
        }

        /** @var Service $result */
        return $result;
    }

    /**
     * @param ServiceGroup $serviceGroup
     *
     * @return Service[]
     */
    public function listAll(ServiceGroup $serviceGroup): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('s')
                   ->from('AuthenticationBundle:Service', 's')
                   ->where("s.serviceGroup = :serviceGroup")
                   ->andWhere("s.visible = true")
                   ->setParameter('serviceGroup', $serviceGroup)
                   ->orderBy('s.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
