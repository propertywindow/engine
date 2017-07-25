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
        return [
            'id'       => $property->getId(),
            'street'   => $property->getStreet(),
            'agent_id' => $property->getAgentId(),
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
