<?php declare(strict_types = 1);

namespace AuthenticationBundle\Service\Blacklist;

use AuthenticationBundle\Entity\Blacklist;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\Blacklist
 */
class Mapper
{
    /**
     * @param Blacklist $blacklist
     *
     * @return array
     */
    public static function fromBlacklist(Blacklist $blacklist): array
    {
        if ($blacklist->getUpdated() !== null) {
            $date = $blacklist->getUpdated();
        } else {
            $date = $blacklist->getCreated();
        }

        return [
            'id'       => $blacklist->getId(),
            'user_id'  => $blacklist->getUser()->getId(),
            'agent_id' => $blacklist->getAgent()->getId(),
            'ip'       => $blacklist->getIp(),
            'amount'   => $blacklist->getAmount(),
            'date'     => $date,
        ];
    }

    /**
     * @param Blacklist[] ...$blacklists
     *
     * @return array
     */
    public static function fromBlacklists(Blacklist ...$blacklists): array
    {
        return array_map(
            function(Blacklist $blacklist) {
                return self::fromBlacklist($blacklist);
            },
            $blacklists
        );
    }
}
