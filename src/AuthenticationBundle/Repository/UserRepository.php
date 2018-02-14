<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Repository;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\UserType;
use Doctrine\ORM\EntityRepository;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use Doctrine\ORM\OptimisticLockException;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return User
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
     * @param int[] $identifiers
     *
     * @return User[]
     * @throws OptimisticLockException
     */
    public function findByUserIdentifiers(array $identifiers): array
    {
        /** @var User[] $users */
        $users = $this->findBy(['id' => $identifiers]);

        $userIdentifiersFound = array_map(
            function(User $user) {
                return $user->getId();
            },
            $users
        );

        $userIdentifiersNotFound = array_diff($identifiers, $userIdentifiersFound);
        if (count($userIdentifiersNotFound) > 0) {
            $entityManager = $this->getEntityManager();
            $i             = 0;
            $insertedUsers = [];
            foreach ($userIdentifiersNotFound as $identifier) {
                $user = new User();
                $user->setId($identifier);

                $entityManager->persist($user);
                $insertedUsers[] = $user;

                if ($i % 50 === 0) {
                    $entityManager->flush();
                }

                $i++;
            }

            $entityManager->flush($insertedUsers);
            $users = array_merge($users, $insertedUsers);
        }

        return $users;
    }

    /**
     * @param User     $user
     * @param UserType $adminType
     * @param UserType $colleagueType
     *
     * @return array|User[]
     */
    public function listAll(User $user, UserType $adminType, UserType $colleagueType): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:User', 'u')
                   ->where('u.userType = :adminType')
                   ->andWhere("u.agent = :agent")
                   ->orWhere('u.userType = :colleagueType')
                   ->andWhere("u.agent = :agent")
                   ->setParameter('agent', $user->getAgent())
                   ->setParameter('adminType', $adminType)
                   ->setParameter('colleagueType', $colleagueType)
                   ->orderBy('u.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param Agent    $agent
     * @param UserType $colleagueType
     *
     * @return array|User[]
     */
    public function agentListAll(Agent $agent, UserType $colleagueType): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:User', 'u')
                   ->where('u.userType = :colleagueType')
                   ->andWhere("u.agent = :agent")
                   ->setParameter('agent', $agent)
                   ->setParameter('colleagueType', $colleagueType)
                   ->orderBy('u.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int[]    $agentIds
     * @param UserType $userType
     *
     * @return User[]
     */
    public function listColleagues(array $agentIds, UserType $userType): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('u')
                   ->from('AuthenticationBundle:User', 'u')
                   ->where("u.agent IN (:agentIds)")
                   ->andWhere('u.userType = :userType')
                   ->setParameter('agentIds', $agentIds)
                   ->setParameter('userType', $userType)
                   ->orderBy('u.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param int $id
     *
     * @return int $userType
     * @throws UserNotFoundException
     */
    public function getUserType(int $id): int
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new UserNotFoundException($id);
        }

        $userType = (int) $result->getTypeId();

        return $userType;
    }
}
