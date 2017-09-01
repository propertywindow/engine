<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use AuthenticationBundle\Entity\Blacklist;

/**
 * @package AuthenticationBundle\Service
 */
class BlacklistService
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
     * @return Blacklist $service
     */
    public function getBlacklist(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Blacklist');
        $blacklist  = $repository->findById($id);

        return $blacklist;
    }

    /**
     * @param Agent $agent
     *
     * @return array|Blacklist[]
     */
    public function getBlacklists(Agent $agent)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Blacklist');

        return $repository->listAll($agent);
    }

    /**
     * @param string $ipAddress
     *
     * @return Blacklist $service
     */
    public function checkBlacklist(string $ipAddress)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Blacklist');
        $blacklist  = $repository->findOneBy(['ip' => $ipAddress]);

        return $blacklist;
    }

    /**
     * @param string     $ipAddress
     * @param null|User  $user
     * @param null|Agent $agent
     *
     * @return Blacklist
     */
    public function createBlacklist(string $ipAddress, ?User $user, ?Agent $agent)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Blacklist');
        $blacklist  = $repository->findOneBy(['ip' => $ipAddress]);

        if ($blacklist === null) {
            $blacklist = new Blacklist();

            if ($user) {
                $blacklist->setUser($user);
                $blacklist->setAgent($agent);
            }

            $blacklist->setIp($ipAddress);

            $this->entityManager->persist($blacklist);
        } else {
            $amount = (int)$blacklist->getAmount() + 1;
            $blacklist->setAmount($amount);
        }

        $this->entityManager->flush();

        return $blacklist;
    }

    /**
     * @param int $id
     */
    public function removeBlacklist(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Blacklist');
        $blacklist  = $repository->findById($id);

        $this->entityManager->remove($blacklist);
        $this->entityManager->flush();
    }
}
