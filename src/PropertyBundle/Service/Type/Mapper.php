<?php declare(strict_types=1);

namespace PropertyBundle\Service\Type;

use PropertyBundle\Entity\Type;

/**
 * Class Mapper
 * @package PropertyBundle\Service\Type
 */
class Mapper
{
    /**
     * @param Type $type
     *
     * @return array
     */
    public static function fromType(Type $type): array
    {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        switch ($lang) {
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
     * @param Type[] ...$types
     *
     * @return array
     */
    public static function fromTypes(Type ...$types): array
    {
        return array_map(
            function (Type $type) {
                return self::fromType($type);
            },
            $types
        );
    }
}
