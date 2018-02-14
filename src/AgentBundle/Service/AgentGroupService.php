<?php
declare(strict_types = 1);

namespace AgentBundle\Service;

use AgentBundle\Entity\AgentGroup;
use AgentBundle\Repository\AgentGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Exceptions\AgentGroupNotFoundException;

/**
 * AgentGroup Service
 */
class AgentGroupService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AgentGroupRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(AgentGroup::class);
    }

    /**
     * @param int $id
     *
     * @return AgentGroup
     * @throws AgentGroupNotFoundException
     */
    public function getAgentGroup(int $id): AgentGroup
    {
        return $this->repository->findById($id);
    }

    /**
     * @return AgentGroup[]
     */
    public function getAgentGroups(): array
    {
        return $this->repository->listAll();
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return AgentGroup
     */
    public function createAgentGroup(AgentGroup $agentGroup): AgentGroup
    {
        $this->entityManager->persist($agentGroup);
        $this->entityManager->flush();

        return $agentGroup;
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return AgentGroup
     */
    public function updateAgentGroup(AgentGroup $agentGroup): AgentGroup
    {
        $this->entityManager->flush();

        return $agentGroup;
    }

    /**
     * @param int $id
     *
     * @throws AgentGroupNotFoundException
     */
    public function deleteAgentGroup(int $id)
    {
        $agentGroup = $this->repository->findById($id);

        $this->entityManager->remove($agentGroup);
        $this->entityManager->flush();
    }
}
