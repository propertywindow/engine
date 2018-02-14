<?php declare(strict_types = 1);

namespace AuthenticationBundle\Repository;

use AuthenticationBundle\Entity\UserType;
use AuthenticationBundle\Exceptions\UserTypeNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * UserTypeRepository
 */
class UserTypeRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return UserType
     * @throws UserTypeNotFoundException
     */
    public function findById(int $id): UserType
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new UserTypeNotFoundException($id);
        }

        /** @var UserType $result */
        return $result;
    }

    /**
     * @param bool $visible
     *
     * @return UserType[]
     */
    public function listAll(bool $visible): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:UserType', 'u');

        if ($visible) {
            $qb->where("u.visible = :visible")
               ->setParameter('visible', $visible);
        }

        $qb->orderBy('u.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
