<?php declare(strict_types = 1);

namespace PropertyBundle\Service\SubType;

use PropertyBundle\Entity\SubType;

/**
 * Class Mapper
 * @package PropertyBundle\Service\SubType
 */
class Mapper
{
    /**
     * @param string  $language
     * @param SubType $subtype
     *
     * @return array
     */
    public static function fromSubType(string $language, SubType $subtype): array
    {
        switch ($language) {
            case "nl":
                return [
                    'id'      => $subtype->getId(),
                    'type_id' => $subtype->getType()->getId(),
                    'subtype' => $subtype->getNl(),
                ];
            default:
                return [
                    'id'      => $subtype->getId(),
                    'type_id' => $subtype->getType()->getId(),
                    'subtype' => $subtype->getEn(),
                ];
        }
    }

    /**
     * @param string    $language
     * @param SubType[] ...$subtypes
     *
     * @return array
     */
    public static function fromSubTypes(string $language, SubType ...$subtypes): array
    {
        return array_map(
            function (SubType $subtype) use ($language) {
                return self::fromSubType($language, $subtype);
            },
            $subtypes
        );
    }
}
