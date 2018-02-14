<?php declare(strict_types = 1);

namespace AgentBundle\Service\AgentGroup;

use AgentBundle\Entity\AgentGroup;

/**
 * Class Mapper
 * @package AgentBundle\Service\AgentGroup
 */
class Mapper
{
    /**
     * @param AgentGroup $agentGroup
     *
     * @return array
     */
    public static function fromAgentGroup(AgentGroup $agentGroup): array
    {
        return [
            'id'   => $agentGroup->getId(),
            'name' => $agentGroup->getName(),
        ];
    }

    /**
     * @param AgentGroup[] ...$agentGroups
     *
     * @return array
     */
    public static function fromAgentGroups(AgentGroup ...$agentGroups): array
    {
        return array_map(
            function (AgentGroup $agentGroup) {
                return self::fromAgentGroup($agentGroup);
            },
            $agentGroups
        );
    }
}
