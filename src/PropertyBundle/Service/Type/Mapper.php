<?php
declare(strict_types=1);

namespace PropertyBundle\Service\Type;

use PropertyBundle\Entity\Type;

/**
 * Class Mapper
 * @package PropertyBundle\Service\Type
 */
class Mapper
{
    /**
     * @param string  $language
     * @param Type $type
     *
     * @return array
     */
    public static function fromType(string $language, Type $type): array
    {
        switch ($language) {
            case "nl":
                return [
                    'id'   => $type->getId(),
                    'type' => $type->getNl(),
                ];
            default:
                return [
                    'id'   => $type->getId(),
                    'type' => $type->getEn(),
                ];
        }
    }

    /**
     * @param string  $language
     * @param Type[] ...$types
     *
     * @return array
     */
    public static function fromTypes(string $language, Type ...$types): array
    {
        return array_map(
            function (Type $type) use ($language) {
                return self::fromType($language, $type);
            },
            $types
        );
    }
}
