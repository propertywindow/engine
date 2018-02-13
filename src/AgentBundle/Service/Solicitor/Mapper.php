<?php
declare(strict_types = 1);

namespace AgentBundle\Service\Solicitor;

use AgentBundle\Entity\Solicitor;

/**
 * Class Mapper
 */
class Mapper
{
    /**
     * @param Solicitor $solicitor
     *
     * @return array
     */
    public static function fromSolicitor(Solicitor $solicitor): array
    {
        $country = $solicitor->getCountry();

        switch ($country) {
            case "NL":
                $address = $solicitor->getStreet() . ' ' . $solicitor->getHouseNumber();
                break;
            default:
                $address = $solicitor->getHouseNumber() . ' ' . $solicitor->getStreet();
                break;
        }

        return [
            'id'           => $solicitor->getId(),
            'address'      => $address,
            'street'       => $solicitor->getStreet(),
            'house_number' => $solicitor->getHouseNumber(),
            'postcode'     => $solicitor->getPostcode(),
            'city'         => $solicitor->getCity(),
            'phone'        => $solicitor->getPhone(),
            'fax'          => $solicitor->getFax(),
            'email'        => $solicitor->getEmail(),
        ];
    }

    /**
     * @param Solicitor[] ...$solicitors
     *
     * @return array
     */
    public static function fromSolicitors(Solicitor ...$solicitors): array
    {
        return array_map(
            function (Solicitor $solicitor) {
                return self::fromSolicitor($solicitor);
            },
            $solicitors
        );
    }
}
