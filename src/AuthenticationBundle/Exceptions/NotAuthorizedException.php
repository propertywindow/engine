<?php declare(strict_types=1);

namespace AuthenticationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AuthenticationBundle\Exceptions
 */
class NotAuthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf("User is not authorized."));
    }
}
