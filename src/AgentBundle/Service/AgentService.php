<?php declare(strict_types=1);

namespace AgentBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Entity\Agent;

/**
 * @package AgentBundle\Service
 */
class AgentService
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
     * @return Agent $agent
     */
    public function getAgent(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');
        $agent      = $repository->findById($id);

        return $agent;
    }

    /**
     * @return Agent[]
     */
    public function getAgents()
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');

        return $repository->listAll();
    }

    /**
     * @param int $agentId
     *
     * @return int[] $groupIds
     */
    public function getAgentIdsFromGroup(int $agentId)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');
        $agent      = $repository->findById($agentId);
        $groupIds   = $repository->getAgentIdsFromGroupId((int)$agent->getAgentGroup()->getId());

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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteAgent(int $id)
    {
        $agentRepository = $this->entityManager->getRepository('AgentBundle:Agent');
        $agent           = $agentRepository->findById($id);

        $this->entityManager->remove($agent);
        $this->entityManager->flush();
    }
}
