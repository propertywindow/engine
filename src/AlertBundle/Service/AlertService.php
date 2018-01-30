<?php
declare(strict_types=1);

namespace AlertBundle\Service;

use AgentBundle\Entity\AgentGroup;
use AlertBundle\Repository\AlertRepository;
use Doctrine\ORM\EntityManagerInterface;
use AlertBundle\Entity\Alert;
use AlertBundle\Exceptions\AlertNotFoundException;

/**
 * Alert Service
 */
class AlertService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AlertRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Alert::class);
    }

    /**
     * @param int $id
     *
     * @return Alert
     * @throws AlertNotFoundException
     */
    public function getAlert(int $id): Alert
    {
        return $this->repository->findById($id);
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return Alert[]
     */
    public function getAlerts(AgentGroup $agentGroup): array
    {
        return $this->repository->findByAgent($agentGroup);
    }

    /**
     * @param Alert $alert
     *
     * @return Alert
     */
    public function createAlert(Alert $alert): Alert
    {
        $this->entityManager->persist($alert);
        $this->entityManager->flush();

        return $alert;
    }

    /**
     * @param Alert $alert
     *
     * @return Alert
     */
    public function updateAlert(Alert $alert): Alert
    {
        $this->entityManager->flush();

        return $alert;
    }
}
