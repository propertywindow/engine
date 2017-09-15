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
        switch ($user->getCountry()) {
            case "NL":
                $address = $user->getStreet().' '.$user->getHouseNumber();
                break;
            case "GB":
                $address = $user->getHouseNumber().' '.$user->getStreet();
                break;
            default:
                $address = $user->getStreet().' '.$user->getHouseNumber();
        }

        $onlineNow = false;
        if ($user->getLastOnline()) {
            if ($user->getLastOnline()->getTimestamp() > strtotime('-5 min')) {
                $onlineNow = true;
            }
        }

        return [
            'id'           => $user->getId(),
            'active'       => $user->getActive(),
            'email'        => $user->getEmail(),
            'agent_id'     => $user->getAgent()->getId(),
            'agent_name'   => $user->getAgent()->getAgentGroup()->getName(),
            'office'       => $user->getAgent()->getOffice(),
            'user_type_id' => $user->getUserType()->getId(),
            'full_name'    => $user->getFirstName().' '.$user->getLastName(),
            'first_name'   => $user->getFirstName(),
            'last_name'    => $user->getLastName(),
            'address'      => $address,
            'street'       => $user->getStreet(),
            'house_number' => $user->getHouseNumber(),
            'postcode'     => $user->getPostcode(),
            'city'         => $user->getCity(),
            'country'      => $user->getCountry(),
            'avatar'       => $user->getAvatar(),
            'phone'        => $user->getPhone(),
            'last_login'   => $user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d H:i:s') : null,
            'last_online'  => $user->getLastOnline() ? $user->getLastOnline()->format('Y-m-d H:i:s') : null,
            'first_login'  => $user->getLastLogin() ? false : true,
            'online_now'   => $onlineNow,
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
