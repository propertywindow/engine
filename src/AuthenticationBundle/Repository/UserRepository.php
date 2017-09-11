<?php declare(strict_types=1);

namespace AuthenticationBundle\Repository;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\UserType;
use Doctrine\ORM\EntityRepository;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\UserNotFoundException;

/**
 * UserRepository
 *
 */
class UserRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function findById(int $id): User
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new UserNotFoundException($id);
        }

        /** @var User $result */
        return $result;
    }

    /**
     * @param User $user
     *
     * @return User[]
     */
    public function listAll(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:User', 'u')
                   ->where("u.agent = :agent")
                   ->andWhere('u.id != :userId')
                   ->setParameter('agent', $user->getAgent())
                   ->setParameter('userId', $user->getId())
                   ->orderBy('u.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param User $user
     * @param UserType $userType
     *
     * @return User[]
     */
    public function listColleagues(User $user, UserType $userType): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:User', 'u')
                   ->where("u.agent = :agent")
                   ->andWhere('u.userType <= :userType')
                   ->setParameter('agent', $user->getAgent())
                   ->setParameter('userType', $userType)
                   ->orderBy('u.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int $id
     *
     * @return int $userType
     *
     * @throws UserNotFoundException
     */
    public function getUserType(int $id): int
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new UserNotFoundException($id);
        }

        $userType = (int)$result->getTypeId();

        return $userType;
    }
}
