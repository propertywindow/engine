<?php
declare(strict_types = 1);

namespace AppBundle\Exceptions;

/**
 * SettingsNotFound Exception
 */
class SettingsNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf("Could not find email with settings"));
    }
}
