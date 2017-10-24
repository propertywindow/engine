<?php declare(strict_types=1);

namespace AgentBundle\Service;

use AgentBundle\Entity\Agent;
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
     * @param Agent $agent
     *
     * @return AgentSettings $agent
     */
    public function getSettings(Agent $agent)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:AgentSettings');
        $agent      = $repository->findByAgent($agent);

        return $agent;
    }
}
