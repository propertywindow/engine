<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\UserType;
use Doctrine\ORM\EntityManagerInterface;
use AuthenticationBundle\Entity\User;

/**
 * @package AuthenticationBundle\Service
 */
class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return User $user
     */
    public function getUser(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->findById($id);

        return $user;
    }

    /**
     * @param Agent $agent
     *
     * @return User $user
     */
    public function getUsers(Agent $agent)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->listAll($agent);

        return $user;
    }

    /**
     * @param array    $parameters
     *
     * @param Agent    $agent
     * @param UserType $userType
     *
     * @return User
     */
    public function createUser(array $parameters, Agent $agent, UserType $userType)
    {
        $user = new User();

        $user->setEmail(strtolower($parameters['email']));
        $user->setPassword(md5($parameters['password']));
        $user->setFirstName(ucfirst($parameters['first_name']));
        $user->setLastName(ucfirst($parameters['last_name']));
        $user->setStreet(ucwords($parameters['street']));
        $user->setHouseNumber($parameters['house_number']);
        $user->setPostcode($parameters['postcode']);
        $user->setCity(ucwords($parameters['city']));
        $user->setCountry($parameters['country']);

        $user->setAgent($agent);
        $user->setUserType($userType);

        if (array_key_exists('active', $parameters) && $parameters['active'] !== null) {
            $user->setActive((bool)$parameters['active']);
        }

        if (array_key_exists('phone', $parameters) && $parameters['phone'] !== null) {
            $user->setPhone((string)$parameters['phone']);
        }

        if (array_key_exists('avatar', $parameters) && $parameters['avatar'] !== null) {
            $user->setAvatar((string)$parameters['avatar']);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function updateUser(User $user)
    {
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param int $id
     */
    public function disableUser(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->findById($id);

        $user->setActive(false);

        $this->entityManager->flush();
    }

    /**
     * @param int $id
     */
    public function deleteUser(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->findById($id);

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
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->findOneBy(['email' => $email]);

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
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->findOneBy(
            [
                'email'    => $email,
                'password' => $password,
                'active'   => true,
            ]
        );

        if ($user) {
            $user->setLastLogin(new \DateTime());
            $this->entityManager->flush();
        }

        return $user;
    }
}
