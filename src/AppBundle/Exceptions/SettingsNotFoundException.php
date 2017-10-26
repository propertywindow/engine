<?php declare(strict_types=1);

namespace AppBundle\Exceptions;

/**
 * @package AppBundle\Exceptions
 */
class SettingsNotFoundException extends Exception
{
    /**
     * SettingsNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct(sprintf("Could not find email with settings"));
    }
}
