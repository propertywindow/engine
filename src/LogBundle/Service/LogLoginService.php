<?php declare(strict_types=1);

namespace LogBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Login;
use LogBundle\Exceptions\LoginNotFoundException;

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
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Login $login
     *
     * @throws LoginNotFoundException
     */
    public function getLogin(int $id)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Login');
        $login      = $repository->find($id);

        /** @var Login $login */
        if ($login === null) {
            throw new LoginNotFoundException($id);
        }

        return $login;
    }

    /**
     * @param User   $user
     * @param Agent  $agent
     * @param string $ipAddress
     *
     * @return Login
     */
    public function createLogin(
        User $user,
        Agent $agent,
        string $ipAddress
    ) {
        $login = new Login();

        $login->setUser($user);
        $login->setAgent($agent);
        $login->setIp($ipAddress);

        $this->entityManager->persist($login);
        $this->entityManager->flush();

        return $login;
    }
}
