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
            case "GB":
                $address = $property->getHouseNumber().' '.$property->getStreet();
                break;
            default:
                $address = $property->getStreet().' '.$property->getHouseNumber();
        }

        return [
            'id'           => $property->getId(),
            'agent_id'     => $property->getAgent()->getId(),
            'client_id'    => $property->getClient()->getId(),
            'kind_id'      => $property->getKind()->getId(),
            'terms_id'     => $property->getTerms()->getId(),
            'address'      => $address,
            'street'       => $property->getStreet(),
            'house_number' => $property->getHouseNumber(),
            'postcode'     => $property->getPostcode(),
            'city'         => $property->getCity(),
            'country'      => $property->getCountry(),
            'subtype_id'   => $property->getSubType(),
            'price'        => $property->getPrice(),
            'sold_price'   => $property->getSoldPrice(),
            'espc'         => $property->getEspc(),
            'archived'     => $property->getArchived(),
            'online'       => $property->getOnline(),
            'lat'          => $property->getLat(),
            'lng'          => $property->getLng(),
            'gallery'      => $property->getImages(),
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
