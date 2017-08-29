<?php declare(strict_types=1);

namespace AgentBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Entity\Agent;
use AgentBundle\Exceptions\AgentNotFoundException;

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
     *
     * @throws AgentNotFoundException
     */
    public function getAgent(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');
        $agent      = $repository->find($id);

        /** @var Agent $agent */
        if ($agent === null) {
            throw new AgentNotFoundException($id);
        }

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
     * @param int $id
     *
     * @return int $groupId
     */
    public function getGroupId(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');
        $agent      = $repository->find($id);
        $groupId    = (int)$agent->getGroupId();

        return $groupId;
    }

    /**
     * @param int $agentId
     *
     * @return int[] $groupIds
     */
    public function getAgentIdsFromGroup(int $agentId)
    {
        $groupId    = $this->getGroupId($agentId);
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');
        $groupIds   = $repository->getAgentIdsFromGroupId($groupId);

        return $groupIds;
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
        $type            = $agentRepository->findById($id);

        $this->entityManager->remove($type);
        $this->entityManager->flush();
    }
}
