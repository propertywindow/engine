<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\BlacklistNotFoundException;
use AuthenticationBundle\Repository\BlacklistRepository;
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
     * @var BlacklistRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Blacklist::class);
    }

    /**
     * @param int $id
     *
     * @return Blacklist
     * @throws BlacklistNotFoundException
     */
    public function getBlacklist(int $id): Blacklist
    {
        return $this->repository->findById($id);
    }

    /**
     * @param Agent $agent
     *
     * @return array|Blacklist[]
     */
    public function getBlacklists(Agent $agent): array
    {
        return $this->repository->listAll($agent);
    }

    /**
     * @param string $ipAddress
     *
     * @return Blacklist|null
     */
    public function checkBlacklist(string $ipAddress)
    {
        return $this->repository->findOneBy(['ip' => $ipAddress]);
    }

    /**
     * @param string    $ipAddress
     * @param null|User $user
     *
     * @return Blacklist
     */
    public function createBlacklist(string $ipAddress, ?User $user): Blacklist
    {
        $blacklist = $this->repository->findOneBy(['ip' => $ipAddress]);

        if ($blacklist === null) {
            $blacklist = new Blacklist();

            if ($user) {
                $blacklist->setUser($user);
                $blacklist->setAgent($user->getAgent());
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
     *
     * @throws BlacklistNotFoundException
     */
    public function removeBlacklist(int $id)
    {
        $blacklist = $this->repository->findById($id);

        $this->entityManager->remove($blacklist);
        $this->entityManager->flush();
    }
}
