<?php declare(strict_types=1);

namespace AuthenticationBundle\Service\User;

use AuthenticationBundle\Entity\User;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\User
 */
class Mapper
{
    /**
     * @param User $user
     *
     * @return array
     */
    public static function fromUser(User $user): array
    {
        return [
            'id'           => $user->getId(),
            'active'       => $user->getActive(),
            'email'        => $user->getEmail(),
            'agent_id'     => $user->getAgent()->getId(),
            'user_type_id' => $user->getUserType()->getId(),
            'street'       => $user->getStreet(),
            'house_number' => $user->getHouseNumber(),
            'postcode'     => $user->getPostcode(),
            'city'         => $user->getCity(),
            'country'      => $user->getCountry(),
            'avatar'       => $user->getAvatar(),
            'phone'        => $user->getPhone(),
            'last_login'   => $user->getLastLogin(),
            'first_login'  => $user->getLastLogin() ? true : false,
        ];
    }

    /**
     * @param User[] ...$users
     *
     * @return array
     */
    public static function fromUsers(User ...$users): array
    {
        return array_map(
            function (User $user) {
                return self::fromUser($user);
            },
            $users
        );
    }
}
