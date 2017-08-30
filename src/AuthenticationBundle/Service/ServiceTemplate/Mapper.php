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
            'id'        => $serviceTemplate->getId(),
            'service'   => $serviceTemplate->getService(),
            'user_type' => $serviceTemplate->getUserType(),
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
            function (ServiceTemplate $serviceTemplate) {
                return self::fromServiceTemplate($serviceTemplate);
            },
            $serviceTemplates
        );
    }
}
