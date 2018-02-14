<?php declare(strict_types = 1);

namespace AlertBundle\Service\Alert;

use AlertBundle\Entity\Alert;

/**
 * Class Mapper
 * @package AlertBundle\Service\Alert
 */
class Mapper
{
    /**
     * @param Alert $alert
     *
     * @return array
     */
    public static function fromAlert(Alert $alert): array
    {
        return [
            'id'           => $alert->getId(),
            'applicant_id' => $alert->getApplicant()->getId(),
            'property_id'  => $alert->getProperty()->getId(),
            'read'         => $alert->getRead(),
        ];
    }

    /**
     * @param Alert[] ...$alerts
     *
     * @return array
     */
    public static function fromAlerts(Alert ...$alerts): array
    {
        return array_map(
            function(Alert $alert) {
                return self::fromAlert($alert);
            },
            $alerts
        );
    }
}
