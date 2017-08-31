<?php declare(strict_types=1);

namespace AuthenticationBundle\Service\Service;

use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Entity\ServiceGroup;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\Service
 */
class Mapper
{
    /**
     * @param Service $service
     *
     * @return array
     */
    public static function fromService(Service $service): array
    {
        // todo: get language from user and make switch case

        return [
            'id'          => $service->getId(),
            'description' => $service->getEn(),
            'icon'        => $service->getIcon(),
            'visible'     => $service->getVisible(),
        ];
    }

    /**
     * @param Service[] ...$services
     *
     * @return array
     */
    public static function fromServices(Service ...$services): array
    {
        return array_map(
            function (Service $service) {
                return self::fromService($service);
            },
            $services
        );
    }

    /**
     * @param ServiceGroup $serviceGroup
     *
     * @return array
     */
    public static function fromServiceGroup(ServiceGroup $serviceGroup): array
    {
        return [
            'id'          => $serviceGroup->getId(),
            'description' => $serviceGroup->getEn(),
            'icon'        => $serviceGroup->getIcon(),
        ];
    }

    /**
     * @param ServiceGroup[] ...$serviceGroups
     *
     * @return array
     */
    public static function fromServicesGroup(ServiceGroup ...$serviceGroups): array
    {
        return array_map(
            function (ServiceGroup $serviceGroup) {
                return self::fromServiceGroup($serviceGroup);
            },
            $serviceGroups
        );
    }
}
