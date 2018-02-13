<?php
declare(strict_types = 1);

namespace AgentBundle\Service;

use AgentBundle\Entity\Solicitor;
use AgentBundle\Exceptions\SolicitorNotFoundException;
use AgentBundle\Repository\SolicitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Entity\Agent;

/**
 * Solicitor Service
 */
class SolicitorService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SolicitorRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Solicitor::class);
    }

    /**
     * @param int $id
     *
     * @return Solicitor
     * @throws SolicitorNotFoundException
     */
    public function getSolicitor(int $id): Solicitor
    {
        return $this->repository->findById($id);
    }

    /**
     * @param Agent $agent
     *
     * @return Solicitor[]
     */
    public function getSolicitors(Agent $agent): array
    {
        return $this->repository->listAll($agent);
    }


    /**
     * @param Solicitor $solicitor
     *
     * @return Solicitor
     */
    public function createSolicitor(Solicitor $solicitor): Solicitor
    {
        $this->entityManager->persist($solicitor);
        $this->entityManager->flush();

        return $solicitor;
    }

    /**
     * @param Solicitor $solicitor
     *
     * @return Solicitor
     */
    public function updateSolicitor(Solicitor $solicitor): Solicitor
    {
        $this->entityManager->flush();

        return $solicitor;
    }

    /**
     * @param Solicitor $solicitor
     */
    public function deleteSolicitor(Solicitor $solicitor)
    {
        $this->entityManager->remove($solicitor);
        $this->entityManager->flush();
    }
}
