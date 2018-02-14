<?php declare(strict_types = 1);

namespace AuthenticationBundle\Service\Service;

use AuthenticationBundle\Entity\Service;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\Service
 */
class Mapper
{
    /**
     * @param string  $language
     * @param Service $service
     *
     * @return array
     */
    public static function fromService(string $language, Service $service): array
    {
        switch ($language) {
            case "nl":
                $description = $service->getNl();
                break;
            default:
                $description = $service->getEn();
        }

        return [
            'id'          => $service->getId(),
            'description' => $description,
            'icon'        => $service->getIcon(),
            'url'         => $service->getUrl(),
            'visible'     => $service->getVisible(),
        ];
    }

    /**
     * @param string    $language
     * @param Service[] ...$services
     *
     * @return array
     */
    public static function fromServices(string $language, Service ...$services): array
    {
        return array_map(
            function (Service $service) use ($language) {
                return self::fromService($language, $service);
            },
            $services
        );
    }
}
