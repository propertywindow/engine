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
        $country = $agency->getAddress()->getCountry();

        switch ($country) {
            case "NL":
                $address = $agency->getAddress()->getStreet() . ' ' . $agency->getAddress()->getHouseNumber();
                break;
            default:
                $address = $agency->getAddress()->getHouseNumber() . ' ' . $agency->getAddress()->getStreet();
                break;
        }

        return [
            'id'           => $agency->getId(),
            'name'         => $agency->getName(),
            'agent_id'     => $agency->getAgent()->getId(),
            'address'      => $address,
            'street'       => $agency->getAddress()->getStreet(),
            'house_number' => $agency->getAddress()->getHouseNumber(),
            'postcode'     => $agency->getAddress()->getPostcode(),
            'city'         => $agency->getAddress()->getCity(),
            'country'      => $country,
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
            function (Agency $agency) {
                return self::fromAgency($agency);
            },
            $agencies
        );
    }
}
