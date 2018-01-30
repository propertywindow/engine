<?php
declare(strict_types=1);

namespace LogBundle\Service;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Login;
use LogBundle\Exceptions\LoginNotFoundException;
use LogBundle\Repository\LoginRepository;

/**
 * @package LogBundle\Service
 */
class LogLoginService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LoginRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Login::class);
    }

    /**
     * @param int $id
     *
     * @return Login $login
     * @throws LoginNotFoundException
     */
    public function getLogin(int $id): Login
    {
        $login = $this->repository->find($id);

        /** @var Login $login */
        if ($login === null) {
            throw new LoginNotFoundException($id);
        }

        return $login;
    }

    /**
     * @param User   $user
     * @param string $ipAddress
     *
     * @return Login
     */
    public function createLogin(
        User $user,
        string $ipAddress
    ) {
        $login = new Login();

        $login->setUser($user);
        $login->setAgent($user->getAgent());
        $login->setIp($ipAddress);

        $this->entityManager->persist($login);
        $this->entityManager->flush();

        return $login;
    }
}
