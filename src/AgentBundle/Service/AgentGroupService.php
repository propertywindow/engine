<?php declare(strict_types=1);

namespace AgentBundle\Service;

use AgentBundle\Entity\AgentGroup;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AgentBundle\Service
 */
class AgentGroupService
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
     * @return AgentGroup $agentGroup
     */
    public function getAgentGroup(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:AgentGroup');
        $agentGroup = $repository->findById($id);

        return $agentGroup;
    }

    /**
     * @return AgentGroup[]
     */
    public function getAgentGroups()
    {
        $repository = $this->entityManager->getRepository('AgentBundle:AgentGroup');

        return $repository->listAll();
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return AgentGroup
     */
    public function createAgentGroup(AgentGroup $agentGroup)
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
    public function updateAgentGroup(AgentGroup $agentGroup)
    {
        $this->entityManager->flush();

        return $agentGroup;
    }

    /**
     * @param int $id
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteAgentGroup(int $id)
    {
        $agentGroupRepository = $this->entityManager->getRepository('AgentBundle:AgentGroup');
        $agentGroup           = $agentGroupRepository->findById($id);

        $this->entityManager->remove($agentGroup);
        $this->entityManager->flush();
    }
}
