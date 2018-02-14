<?php declare(strict_types = 1);

namespace AppBundle\Service\Settings;

use AppBundle\Entity\Settings;

/**
 * Class Mapper
 * @package AppBundle\Service\Settings
 */
class Mapper
{
    /**
     * @param Settings $settings
     *
     * @return array
     */
    public static function fromSettings(Settings $settings): array
    {
        return [
            'application_name' => $settings->getApplicationName(),
            'application_url'  => $settings->getApplicationURL(),
            'max_failed_login' => $settings->getMaxFailedLogin(),
        ];
    }
}
