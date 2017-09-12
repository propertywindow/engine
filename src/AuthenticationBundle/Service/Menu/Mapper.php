<?php declare(strict_types=1);

namespace AuthenticationBundle\Service\Menu;

use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Entity\ServiceGroup;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\Menu
 */
class Mapper
{
    /**
     * @param string       $language
     * @param ServiceGroup $serviceGroup
     *
     * @return array
     */
    public static function fromMenu(string $language, ServiceGroup $serviceGroup): array
    {
        switch ($language) {
            case "nl":
                $description = $serviceGroup->getNl();
                break;
            default:
                $description = $serviceGroup->getEn();
        }

        $getServices = $serviceGroup->getServices()->getValues();
        $services    = [];

        foreach ($getServices as $service) {
            /** @var Service $service */
            if ($service->getVisible()) {
                switch ($language) {
                    case "nl":
                        $serviceDescription = $service->getNl();
                        break;
                    default:
                        $serviceDescription = $service->getEn();
                }

                $services[] = [
                    'id'          => $service->getId(),
                    'description' => $serviceDescription,
                    'icon'        => $service->getIcon(),
                    'url'         => $service->getUrl(),
                ];
            }
        }

        return [
            'id'          => $serviceGroup->getId(),
            'description' => $description,
            'icon'        => $serviceGroup->getIcon(),
            'url'         => $serviceGroup->getUrl(),
            'services'    => $services,
        ];
    }

    /**
     * @param string         $language
     * @param ServiceGroup[] ...$serviceGroups
     *
     * @return array
     */
    public static function fromMenus(string $language, ServiceGroup ...$serviceGroups): array
    {
        return array_map(
            function (ServiceGroup $serviceGroup) use ($language) {
                return self::fromMenu($language, $serviceGroup);
            },
            $serviceGroups
        );
    }
}
