<?php declare(strict_types = 1);

namespace AuthenticationBundle\Service\ServiceTemplate;

use AuthenticationBundle\Entity\ServiceGroupTemplate;
use AuthenticationBundle\Entity\ServiceTemplate;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\ServiceTemplate
 */
class Mapper
{
    /**
     * @param ServiceTemplate $serviceTemplate
     *
     * @return array
     */
    public static function fromServiceTemplate(ServiceTemplate $serviceTemplate): array
    {
        return [
            'service_id' => $serviceTemplate->getService()->getId(),
        ];
    }

    /**
     * @param ServiceTemplate[] ...$serviceTemplates
     *
     * @return array
     */
    public static function fromServiceTemplates(ServiceTemplate ...$serviceTemplates): array
    {
        return array_map(
            function(ServiceTemplate $serviceTemplate) {
                return self::fromServiceTemplate($serviceTemplate);
            },
            $serviceTemplates
        );
    }

    /**
     * @param ServiceGroupTemplate $serviceGroupTemplate
     *
     * @return array
     */
    public static function fromServiceGroupTemplate(ServiceGroupTemplate $serviceGroupTemplate): array
    {
        return [
            'service_group_id' => $serviceGroupTemplate->getServiceGroup()->getId(),
        ];
    }

    /**
     * @param ServiceGroupTemplate[] ...$serviceGroupTemplates
     *
     * @return array
     */
    public static function fromServiceGroupTemplates(ServiceGroupTemplate ...$serviceGroupTemplates): array
    {
        return array_map(
            function(ServiceGroupTemplate $serviceGroupTemplate) {
                return self::fromServiceGroupTemplate($serviceGroupTemplate);
            },
            $serviceGroupTemplates
        );
    }
}
