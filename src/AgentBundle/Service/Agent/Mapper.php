<?php
declare(strict_types = 1);

namespace AgentBundle\Service\Agent;

use AgentBundle\Entity\Agent;

/**
 * Class Mapper
 */
class Mapper
{
    /**
     * @param Agent $agent
     *
     * @return array
     */
    public static function fromAgent(Agent $agent): array
    {
        $country = $agent->getAddress()->getCountry();

        switch ($country) {
            case "NL":
                $address = $agent->getAddress()->getStreet() . ' ' . $agent->getAddress()->getHouseNumber();
                break;
            default:
                $address = $agent->getAddress()->getHouseNumber() . ' ' . $agent->getAddress()->getStreet();
                break;
        }

        return [
            'id'             => $agent->getId(),
            'agent_group_id' => $agent->getAgentGroup()->getId(),
            'name'           => $agent->getAgentGroup()->getName(),
            'office'         => $agent->getOffice(),
            'agent_user_id'  => $agent->getUser()->getId(),
            'address'        => $address,
            'street'         => $agent->getAddress()->getStreet(),
            'house_number'   => $agent->getAddress()->getHouseNumber(),
            'postcode'       => $agent->getAddress()->getPostcode(),
            'city'           => $agent->getAddress()->getCity(),
            'property_limit' => $agent->getPropertyLimit(),
            'phone'          => $agent->getPhone(),
            'fax'            => $agent->getFax(),
            'email'          => $agent->getEmail(),
            'website'        => $agent->getWebsite(),
            'logo'           => $agent->getLogo(),
            'webprint'       => $agent->getWebprint(),
            'espc'           => $agent->isEspc(),
        ];
    }

    /**
     * @param Agent[] ...$agents
     *
     * @return array
     */
    public static function fromAgents(Agent ...$agents): array
    {
        return array_map(
            function (Agent $agent) {
                return self::fromAgent($agent);
            },
            $agents
        );
    }
}
