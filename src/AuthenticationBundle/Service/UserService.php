<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\UserType;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use AuthenticationBundle\Entity\User;

/**
 * User Service
 */
class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(User::class);
    }

    /**
     * @param int $id
     *
     * @return User $user
     * @throws UserNotFoundException
     */
    public function getUser(int $id)
    {
        $user = $this->repository->findById($id);

        return $user;
    }

    /**
     * @param User     $user
     * @param UserType $adminType
     * @param UserType $colleagueType
     *
     * @return User[] $user
     */
    public function getUsers(User $user, UserType $adminType, UserType $colleagueType)
    {
        $user = $this->repository->getUsers($user, $adminType, $colleagueType);

        return $user;
    }

    /**
     * @param Agent    $agent
     * @param UserType $colleagueType
     *
     * @return User[] $user
     */
    public function getAgentColleagues(Agent $agent, UserType $colleagueType)
    {
        $user = $this->repository->getAgentColleagues($agent, $colleagueType);

        return $user;
    }

    /**
     * @param int[]    $agentIds
     * @param UserType $userType
     *
     * @return User[] $user
     */
    public function getAllColleagues(array $agentIds, UserType $userType)
    {
        $user = $this->repository->getAllColleagues($agentIds, $userType);

        return $user;
    }

    /**
     * @param int      $userId
     * @param int[]    $agentIds
     * @param UserType $userType
     *
     * @return bool
     */
    public function isColleague(int $userId, array $agentIds, UserType $userType): bool
    {
        $users = $this->repository->getAllColleagues($agentIds, $userType);

        foreach ($users as $user) {
            if ($userId === $user->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function createUser(User $user): User
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function updateUser(User $user): User
    {
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function disableUser(User $user): User
    {
        $user->setActive(false);

        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param int $id
     *
     * @throws UserNotFoundException
     */
    public function deleteUser(int $id)
    {
        $user = $this->repository->findById($id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * @param string $email
     *
     * @return User $user
     */
    public function getUserByEmail(string $email)
    {
        $user = $this->repository->findOneBy(['email' => $email]);

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return User $user
     */
    public function login(string $email, string $password)
    {
        $user = $this->repository->findOneBy(
            [
                'email'    => $email,
                'password' => $password,
                'active'   => true,
            ]
        );

        if ($user) {
            $user->setLastLogin(new \DateTime());
            $user->setLastOnline(new \DateTime());
            $this->entityManager->flush();
        }

        return $user;
    }

    /**
     * @param Agent    $agent
     * @param UserType $colleagueType
     *
     * @return User|array|null $user
     */
    public function getApiUser(Agent $agent, UserType $colleagueType)
    {
        $user = $this->repository->getApiUser($agent, $colleagueType);

        return $user;
    }
}
