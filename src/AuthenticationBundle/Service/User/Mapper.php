<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Service\User;

use AuthenticationBundle\Entity\User;

/**
 * Class Mapper
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
        $street      = $user->getAddress()->getStreet();
        $houseNumber = $user->getAddress()->getHouseNumber();
        $country     = $user->getAddress()->getCountry();

        switch ($country) {
            case "NL":
                $address = $street . ' ' . $houseNumber;
                break;
            case "GB":
                $address = $houseNumber . ' ' . $street;
                break;
            default:
                $address = $street . ' ' . $houseNumber;
        }

        return [
            'id'           => $user->getId(),
            'active'       => $user->getActive(),
            'email'        => $user->getEmail(),
            'agent_id'     => $user->getAgent()->getId(),
            'agent_name'   => $user->getAgent()->getAgentGroup()->getName(),
            'office'       => $user->getAgent()->getOffice(),
            'user_type_id' => $user->getUserType()->getId(),
            'full_name'    => $user->getFirstName() . ' ' . $user->getLastName(),
            'first_name'   => $user->getFirstName(),
            'last_name'    => $user->getLastName(),
            'address'      => $address,
            'street'       => $street,
            'house_number' => $houseNumber,
            'postcode'     => $user->getAddress()->getPostcode(),
            'city'         => $user->getAddress()->getCity(),
            'country'      => $country,
            'avatar'       => $user->getAvatar(),
            'phone'        => $user->getPhone(),
            'last_login'   => $user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d H:i:s') : null,
            'last_online'  => $user->getLastOnline() ? $user->getLastOnline()->format('Y-m-d H:i:s') : null,
            'first_login'  => $user->getLastLogin() ? false : true,
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
