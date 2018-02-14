<?php
declare(strict_types = 1);

namespace AgentBundle\Service;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\AgentSettings;
use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AgentBundle\Repository\AgentSettingsRepository;
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
     * @var AgentSettingsRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(AgentSettings::class);
    }

    /**
     * @param Agent $agent
     *
     * @return AgentSettings
     * @throws AgentSettingsNotFoundException
     */
    public function getSettings(Agent $agent): AgentSettings
    {
        return $this->repository->findByAgent($agent);
    }

    /**
     * @param AgentSettings $agentSettings
     *
     * @return AgentSettings
     */
    public function updateSettings(AgentSettings $agentSettings): AgentSettings
    {
        $this->entityManager->flush();

        return $agentSettings;
    }
}
