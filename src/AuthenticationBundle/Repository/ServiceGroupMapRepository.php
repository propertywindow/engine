<?php declare(strict_types=1);

namespace AuthenticationBundle\Repository;

use AuthenticationBundle\Entity\ServiceGroupMap;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\ServiceMapNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * ServiceGroupMapRepository
 *
 */
class ServiceGroupMapRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return ServiceGroupMap
     *
     * @throws ServiceMapNotFoundException
     */
    public function findById(int $id): ServiceGroupMap
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ServiceMapNotFoundException($id);
        }

        /** @var ServiceGroupMap $result */
        return $result;
    }

    /**
     * @param User $user
     *
     * @return ServiceGroupMap[]
     */
    public function listAll(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('s')
                   ->from('AuthenticationBundle:ServiceGroupMap', 's')
                   ->where("s.user = :user")
                   ->setParameter('user', $user)
                   ->orderBy('s.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
