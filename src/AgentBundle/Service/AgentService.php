<?php
declare(strict_types=1);

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
     * @return Agent $agent
     * @throws AgentNotFoundException
     */
    public function getAgent(int $id)
    {
        $agent      = $this->repository->findById($id);

        return $agent;
    }

    /**
     * @return Agent[]
     */
    public function getAgents(): array
    {
        return $this->repository->listAll();
    }

    /**
     * @param int $agentId
     *
     * @return int[] $groupIds
     * @throws AgentNotFoundException
     */
    public function getAgentIdsFromGroup(int $agentId)
    {
        $agent      = $this->repository->findById($agentId);
        $groupIds   = $this->repository->getAgentIdsFromGroupId((int)$agent->getAgentGroup()->getId());

        return $groupIds;
    }


    /**
     * @param Agent $agent
     *
     * @return Agent
     */
    public function createAgent(Agent $agent)
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
    public function updateAgent(Agent $agent)
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
        $agent           = $this->repository->findById($id);

        $this->entityManager->remove($agent);
        $this->entityManager->flush();
    }
}
