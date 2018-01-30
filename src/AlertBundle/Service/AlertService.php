<?php
declare(strict_types=1);

namespace AlertBundle\Service;

use AgentBundle\Entity\AgentGroup;
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
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Alert $alert
     * @throws AlertNotFoundException
     */
    public function getAlert(int $id): Alert
    {
        $repository = $this->entityManager->getRepository(Alert::class);
        $alert      = $repository->findById($id);

        return $alert;
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return Alert[]
     */
    public function getAlerts(AgentGroup $agentGroup)
    {
        $repository = $this->entityManager->getRepository(Alert::class);

        return $repository->findByAgent($agentGroup);
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
