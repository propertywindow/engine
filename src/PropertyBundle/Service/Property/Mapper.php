<?php declare(strict_types=1);

namespace PropertyBundle\Service\Property;

use PropertyBundle\Entity\Property;

/**
 * Class Mapper
 * @package PropertyBundle\Service\Property
 */
class Mapper
{
    /**
     * @param Property $property
     *
     * @return array
     */
    public static function fromProperty(Property $property): array
    {
        $country = $property->getCountry();

        switch ($country) {
            case "NL":
                return [
                    'id'           => $property->getId(),
                    'address'      => $property->getStreet().' '.$property->getHouseNumber(),
                    'street'       => $property->getStreet(),
                    'house_number' => $property->getHouseNumber(),
                    'postcode'     => $property->getPostcode(),
                    'city'         => $property->getCity(),
                    'agent_id'     => $property->getAgentId(),
                    'subtype_id'   => $property->getSubType(),
                ];
            default:
                return [
                    'id'           => $property->getId(),
                    'address'      => $property->getHouseNumber().' '.$property->getStreet(),
                    'street'       => $property->getStreet(),
                    'house_number' => $property->getHouseNumber(),
                    'postcode'     => $property->getPostcode(),
                    'city'         => $property->getCity(),
                    'agent_id'     => $property->getAgentId(),
                    'subtype_id'   => $property->getSubType(),
                ];
        }
    }

    /**
     * @param Property[] ...$properties
     *
     * @return array
     */
    public static function fromProperties(Property ...$properties): array
    {
        return array_map(
            function (Property $property) {
                return self::fromProperty($property);
            },
            $properties
        );
    }
}
