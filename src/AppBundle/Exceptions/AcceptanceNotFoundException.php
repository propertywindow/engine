<?php
declare(strict_types = 1);

namespace AppBundle\Exceptions;

/**
 * AcceptanceNotFound Exception
 */
class AcceptanceNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf("Could not find acceptance"));
    }
}
