<?php declare(strict_types=1);

namespace PropertyBundle\Service\SubType;

use PropertyBundle\Entity\SubType;

/**
 * Class Mapper
 * @package PropertyBundle\Service\SubType
 */
class Mapper
{
    /**
     * @param SubType $subtype
     *
     * @return array
     */
    public static function fromSubType(SubType $subtype): array
    {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        switch ($lang) {
            case "nl":
                return [
                    'id'      => $subtype->getId(),
                    'subtype' => $subtype->getNl(),
                ];
            case "en":
                return [
                    'id'      => $subtype->getId(),
                    'subtype' => $subtype->getEn(),
                ];
            default:
                return [
                    'id'      => $subtype->getId(),
                    'subtype' => $subtype->getEn(),
                ];
        }
    }

    /**
     * @param SubType[] ...$subtypes
     *
     * @return array
     */
    public static function fromSubTypes(SubType ...$subtypes): array
    {
        return array_map(
            function (SubType $subtype) {
                return self::fromSubType($subtype);
            },
            $subtypes
        );
    }
}
