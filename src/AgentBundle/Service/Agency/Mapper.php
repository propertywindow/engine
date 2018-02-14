<?php
declare(strict_types = 1);

namespace AgentBundle\Service\Agency;

use AgentBundle\Entity\Agency;

/**
 * Class Mapper
 */
class Mapper
{
    /**
     * @param Agency $agency
     *
     * @return array
     */
    public static function fromAgency(Agency $agency): array
    {
        $country = $agency->getCountry();

        switch ($country) {
            case "NL":
                $address = $agency->getStreet() . ' ' . $agency->getHouseNumber();
                break;
            default:
                $address = $agency->getHouseNumber() . ' ' . $agency->getStreet();
                break;
        }

        return [
            'id'           => $agency->getId(),
            'name'         => $agency->getName(),
            'agent_id'     => $agency->getAgent()->getId(),
            'address'      => $address,
            'street'       => $agency->getStreet(),
            'house_number' => $agency->getHouseNumber(),
            'postcode'     => $agency->getPostcode(),
            'city'         => $agency->getCity(),
            'phone'        => $agency->getPhone(),
            'fax'          => $agency->getFax(),
            'email'        => $agency->getEmail(),
        ];
    }

    /**
     * @param Agency[] ...$agencies
     *
     * @return array
     */
    public static function fromAgencies(Agency ...$agencies): array
    {
        return array_map(
            function(Agency $agency) {
                return self::fromAgency($agency);
            },
            $agencies
        );
    }
}
