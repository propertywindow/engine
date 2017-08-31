<?php declare(strict_types=1);

namespace AuthenticationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AuthenticationBundle\Exceptions
 */
class LoginFailedException extends Exception
{
    /**
     * @var string
     */
    private $username;

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;

        parent::__construct(sprintf("Could not login with username: %s", $username));
    }
}
