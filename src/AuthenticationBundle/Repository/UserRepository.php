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
     * @param Agent $agent
     *
     * @return User[]
     */
    public function listAll(Agent $agent): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:User', 'u')
                   ->where("u.agent = :agent")
                   ->setParameter('agent', $agent)
                   ->orderBy('u.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param Agent    $agent
     * @param UserType $userType
     *
     * @return User[]
     */
    public function listColleagues(Agent $agent, UserType $userType): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:User', 'u')
                   ->where("u.agent = :agent")
                   ->andWhere('u.userType <= :userType')
                   ->setParameter('agent', $agent)
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
