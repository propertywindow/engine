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
        $country = $solicitor->getAddress()->getCountry();

        switch ($country) {
            case "NL":
                $address = $solicitor->getAddress()->getStreet() . ' ' . $solicitor->getAddress()->getHouseNumber();
                break;
            default:
                $address = $solicitor->getAddress()->getHouseNumber() . ' ' . $solicitor->getAddress()->getStreet();
                break;
        }

        return [
            'id'           => $solicitor->getId(),
            'address'      => $address,
            'street'       => $solicitor->getAddress()->getStreet(),
            'house_number' => $solicitor->getAddress()->getHouseNumber(),
            'postcode'     => $solicitor->getAddress()->getPostcode(),
            'city'         => $solicitor->getAddress()->getCity(),
            'country'      => $country,
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
