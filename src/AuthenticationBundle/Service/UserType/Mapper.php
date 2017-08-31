<?php declare(strict_types=1);

namespace AuthenticationBundle\Service\UserType;

use AuthenticationBundle\Entity\UserType;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\UserType
 */
class Mapper
{
    /**
     * @param UserType $userType
     *
     * @return array
     */
    public static function fromUserType(UserType $userType): array
    {
        return [
            'id' => $userType->getId(),
            'nl' => $userType->getNl(),
            'en' => $userType->getEn(),
        ];
    }

    /**
     * @param UserType[] ...$userTypes
     *
     * @return array
     */
    public static function fromUserTypes(UserType ...$userTypes): array
    {
        return array_map(
            function (UserType $userType) {
                return self::fromUserType($userType);
            },
            $userTypes
        );
    }
}
