<?php declare(strict_types=1);

namespace AgentBundle\Service;

use AgentBundle\Entity\AgentSettings;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AgentBundle\Service
 */
class AgentSettingsService
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
     * @param int $agentId
     *
     * @return AgentSettings $agent
     */
    public function getSettings(int $agentId)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:AgentSettings');
        $agent      = $repository->findByAgentId($agentId);

        return $agent;
    }
}
