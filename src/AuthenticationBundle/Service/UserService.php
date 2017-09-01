<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\UserNotFoundException;

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
     *
     * @throws UserNotFoundException
     */
    public function getUser(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->find($id);

        /** @var User $user */
        if ($user === null) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }

    /**
     * @param string $username
     *
     * @return User $user
     */
    public function getUserByUsername(string $username)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->findOneBy(['username' => $username]);

        return $user;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return User $user
     */
    public function login(string $username, string $password)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $user       = $repository->findOneBy(
            [
                'username' => $username,
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
