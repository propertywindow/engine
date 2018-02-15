<?php
declare(strict_types = 1);

namespace AppBundle\Exceptions;

/**
 * ContactAddress NotFoundException
 */
class ContactAddressNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf("Could not find address"));
    }
}
