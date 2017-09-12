<?php declare(strict_types=1);

namespace PropertyBundle\Service\Property;

use PropertyBundle\Entity\Gallery;
use PropertyBundle\Entity\Property;

/**
 * Class Mapper
 * @package PropertyBundle\Service\Property
 */
class Mapper
{
    /**
     * @param string   $language
     * @param Property $property
     *
     * @return array
     */
    public static function fromProperty(string $language, Property $property): array
    {
        $photo   = null;
        $gallery = [];

        switch ($property->getCountry()) {
            case "NL":
                $address = $property->getStreet().' '.$property->getHouseNumber();
                break;
            case "GB":
                $address = $property->getHouseNumber().' '.$property->getStreet();
                break;
            default:
                $address = $property->getStreet().' '.$property->getHouseNumber();
        }

        switch ($language) {
            case "nl":
                $terms = $property->getTerms()->getNl();
                break;
            case "en":
                $terms = $property->getTerms()->getEn();
                break;
            default:
                $terms = $property->getTerms()->getEn();
        }

        $images = $property->getImages()->getValues();

        foreach ($images as $image) {
            /** @var Gallery $image */
            if ($image->getMain()) {
                $photo = $image->getPath();
            } else {
                $gallery[] = $image->getPath();
            }
        }

        return [
            'id'           => $property->getId(),
            'agent_id'     => $property->getAgent()->getId(),
            'client_id'    => $property->getClient()->getId(),
            'kind_id'      => $property->getKind()->getId(),
            'terms_id'     => $property->getTerms()->getId(),
            'terms'        => $terms,
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
            'photo'        => $photo,
            //            'gallery'      => $gallery,
        ];
    }

    /**
     * @param string     $language
     * @param Property[] ...$properties
     *
     * @return array
     */
    public static function fromProperties(string $language, Property ...$properties): array
    {
        return array_map(
            function (Property $property) use ($language) {
                return self::fromProperty($language, $property);
            },
            $properties
        );
    }
}
