<?php
declare(strict_types = 1);

namespace AgentBundle\Service;

use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Entity\Agent;

/**
 * Agent Service
 */
class AgentService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AgentRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Agent::class);
    }

    /**
     * @param int $id
     *
     * @return Agent
     * @throws AgentNotFoundException
     */
    public function getAgent(int $id): Agent
    {
        return $this->repository->findById($id);
    }

    /**
     * @return Agent[]
     */
    public function getAgents(): array
    {
        return $this->repository->listAll();
    }

    /**
     * @param Agent $agent
     *
     * @return int[]
     */
    public function getAgentIdsFromGroup(Agent $agent): array
    {
        return $this->repository->getAgentIdsFromGroup($agent->getAgentGroup());
    }

    /**
     * @param Agent $agent
     *
     * @return Agent
     */
    public function createAgent(Agent $agent): Agent
    {
        $this->entityManager->persist($agent);
        $this->entityManager->flush();

        return $agent;
    }

    /**
     * @param Agent $agent
     *
     * @return Agent
     */
    public function updateAgent(Agent $agent): Agent
    {
        $this->entityManager->flush();

        return $agent;
    }

    /**
     * @param int $id
     *
     * @throws AgentNotFoundException
     */
    public function deleteAgent(int $id)
    {
        $agent = $this->repository->findById($id);

        $this->entityManager->remove($agent);
        $this->entityManager->flush();
    }
}
