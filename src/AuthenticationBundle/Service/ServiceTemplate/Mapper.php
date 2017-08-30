<?php declare(strict_types=1);

namespace AuthenticationBundle\Service\ServiceTemplate;

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
            'service_id'   => $serviceTemplate->getService()->getId(),
            'service_group'   => $serviceTemplate->getService()->getServiceGroup()->getEn(),
            'service_name' => $serviceTemplate->getService()->getEn(),
        ];

        // todo: return just id for checking default box
    }

    /**
     * @param ServiceTemplate[] ...$serviceTemplates
     *
     * @return array
     */
    public static function fromServiceTemplates(ServiceTemplate ...$serviceTemplates): array
    {
        return array_map(
            function (ServiceTemplate $serviceTemplate) {
                return self::fromServiceTemplate($serviceTemplate);
            },
            $serviceTemplates
        );
    }
}
