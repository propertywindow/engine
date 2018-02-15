<?php
declare(strict_types = 1);

namespace ClientBundle\Service\Client;

use ClientBundle\Entity\Client;

/**
 * Class Mapper
 */
class Mapper
{
    /**
     * @param Client $client
     *
     * @return array
     */
    public static function fromClient(Client $client): array
    {
        $user        = $client->getUser();
        $country     = $user->getAddress()->getCountry();
        $street      = $user->getAddress()->getStreet();
        $houseNumber = $user->getAddress()->getHouseNumber();

        switch ($country) {
            case "NL":
                $address = $street . ' ' . $houseNumber;
                break;
            default:
                $address = $houseNumber . ' ' . $street;
                break;
        }

        return [
            'id'           => $client->getId(),
            'user_id'      => $user->getId(),
            'full_name'    => $user->getFirstName() . ' ' . $user->getLastName(),
            'first_name'   => $user->getFirstName(),
            'last_name'    => $user->getLastName(),
            'address'      => $address,
            'street'       => $street,
            'house_number' => $houseNumber,
            'postcode'     => $user->getAddress()->getPostcode(),
            'city'         => $user->getAddress()->getCity(),
            'country'      => $country,
            'phone'        => $user->getPhone(),
            'email'        => $user->getEmail(),
        ];
    }

    /**
     * @param Client[] ...$clients
     *
     * @return array
     */
    public static function fromClients(Client ...$clients): array
    {
        return array_map(
            function (Client $client) {
                return self::fromClient($client);
            },
            $clients
        );
    }
}
