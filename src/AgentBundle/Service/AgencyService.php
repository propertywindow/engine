<?php
declare(strict_types = 1);

namespace AgentBundle\Service;

use AgentBundle\Entity\Agency;
use AgentBundle\Exceptions\AgencyNotFoundException;
use AgentBundle\Repository\AgencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Entity\Agent;

/**
 * Agency Service
 */
class AgencyService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AgencyRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Agency::class);
    }

    /**
     * @param int $id
     *
     * @return Agency
     * @throws AgencyNotFoundException
     */
    public function getAgency(int $id): Agency
    {
        return $this->repository->findById($id);
    }

    /**
     * @param Agent $agent
     *
     * @return Agency[]
     */
    public function getAgencies(Agent $agent): array
    {
        return $this->repository->listAll($agent);
    }


    /**
     * @param Agency $agency
     *
     * @return Agency
     */
    public function createAgency(Agency $agency): Agency
    {
        $this->entityManager->persist($agency);
        $this->entityManager->flush();

        return $agency;
    }

    /**
     * @param Agency $agency
     *
     * @return Agency
     */
    public function updateAgency(Agency $agency): Agency
    {
        $this->entityManager->flush();

        return $agency;
    }

    /**
     * @param Agency $agency
     */
    public function deleteAgency(Agency $agency)
    {
        $this->entityManager->remove($agency);
        $this->entityManager->flush();
    }
}
