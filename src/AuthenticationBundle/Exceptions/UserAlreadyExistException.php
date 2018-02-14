<?php declare(strict_types = 1);

namespace AuthenticationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AuthenticationBundle\Exceptions
 */
class UserAlreadyExistException extends Exception
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;

        parent::__construct(sprintf("User with email: %s already exists", $email));
    }
}
