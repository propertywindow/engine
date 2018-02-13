<?php
declare(strict_types=1);

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
        $user    = $client->getUser();
        $country = $user->getCountry();

        switch ($country) {
            case "NL":
                $address = $user->getStreet().' '.$user->getHouseNumber();
                break;
            default:
                $address = $user->getHouseNumber().' '.$user->getStreet();
                break;
        }

        return [
            'id'           => $client->getId(),
            'user_id'      => $user->getId(),
            'full_name'    => $user->getFirstName().' '.$user->getLastName(),
            'first_name'   => $user->getFirstName(),
            'last_name'    => $user->getLastName(),
            'address'      => $address,
            'street'       => $user->getStreet(),
            'house_number' => $user->getHouseNumber(),
            'postcode'     => $user->getPostcode(),
            'city'         => $user->getCity(),
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
