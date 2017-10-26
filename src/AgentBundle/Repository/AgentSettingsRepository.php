<?php declare(strict_types=1);

namespace AgentBundle\Repository;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\AgentSettings;
use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * AgentSettingsRepository
 *
 */
class AgentSettingsRepository extends EntityRepository
{
    /**
     * @param Agent $agent
     *
     * @return AgentSettings
     *
     * @throws AgentSettingsNotFoundException
     */
    public function findByAgent(Agent $agent): AgentSettings
    {
        $result = $this->findOneBy([
            'agent' => $agent
        ]);

        if ($result === null) {
            throw new AgentSettingsNotFoundException($agent->getId());
        }

        /** @var AgentSettings $result */
        return $result;
    }
}
