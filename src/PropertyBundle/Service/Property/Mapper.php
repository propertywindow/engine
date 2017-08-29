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
                $address = $property->getStreet().' '.$property->getHouseNumber();
                break;
            default:
                $address = $property->getHouseNumber().' '.$property->getStreet();
        }

        return [
            'id'           => $property->getId(),
            'client_id'    => $property->getClientId(),
            'kind'         => $property->getKind(),
            'address'      => $address,
            'street'       => $property->getStreet(),
            'house_number' => $property->getHouseNumber(),
            'postcode'     => $property->getPostcode(),
            'city'         => $property->getCity(),
            'country'      => $property->getCountry(),
            'agent_id'     => $property->getAgentId(),
            'subtype_id'   => $property->getSubType(),
            'price'        => $property->getPrice(),
            'sold_price'   => $property->getSoldPrice(),
            'espc'         => $property->getEspc(),
            'terms'        => $property->getTerms(),
            'archived'     => $property->getArchived(),
        ];
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
