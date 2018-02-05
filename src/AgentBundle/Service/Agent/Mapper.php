<?php
declare(strict_types=1);

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
        $country = $agent->getCountry();

        switch ($country) {
            case "NL":
                $address = $agent->getStreet().' '.$agent->getHouseNumber();
                break;
            default:
                $address = $agent->getHouseNumber().' '.$agent->getStreet();
                break;
        }


        return [
            'id'             => $agent->getId(),
            'agent_group_id' => $agent->getAgentGroup()->getId(),
            'name'           => $agent->getAgentGroup()->getName(),
            'office'         => $agent->getOffice(),
            'agent_user_id'  => $agent->getUserId(),
            'address'        => $address,
            'street'         => $agent->getStreet(),
            'house_number'   => $agent->getHouseNumber(),
            'postcode'       => $agent->getPostcode(),
            'city'           => $agent->getCity(),
            'property_limit' => $agent->getPropertyLimit(),
            'phone'          => $agent->getPhone(),
            'fax'            => $agent->getFax(),
            'email'          => $agent->getEmail(),
            'website'        => $agent->getWebsite(),
            'logo'           => $agent->getLogo(),
            'webprint'       => $agent->getWebprint(),
            'espc'           => $agent->getEspc(),
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
