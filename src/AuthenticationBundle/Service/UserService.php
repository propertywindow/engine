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

        if ($user === null) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }
}
