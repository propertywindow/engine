<?php declare(strict_types = 1);

namespace AuthenticationBundle\Service\ServiceGroup;

use AuthenticationBundle\Entity\ServiceGroup;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\Service
 */
class Mapper
{
    /**
     * @param string       $language
     * @param ServiceGroup $serviceGroup
     *
     * @return array
     */
    public static function fromServiceGroup(string $language, ServiceGroup $serviceGroup): array
    {
        switch ($language) {
            case "nl":
                $description = $serviceGroup->getNl();
                break;
            default:
                $description = $serviceGroup->getEn();
        }

        return [
            'id'          => $serviceGroup->getId(),
            'description' => $description,
            'icon'        => $serviceGroup->getIcon(),
            'url'         => $serviceGroup->getUrl(),
        ];
    }

    /**
     * @param string         $language
     * @param ServiceGroup[] ...$serviceGroups
     *
     * @return array
     */
    public static function fromServiceGroups(string $language, ServiceGroup ...$serviceGroups): array
    {
        return array_map(
            function (ServiceGroup $serviceGroup) use ($language) {
                return self::fromServiceGroup($language, $serviceGroup);
            },
            $serviceGroups
        );
    }
}
