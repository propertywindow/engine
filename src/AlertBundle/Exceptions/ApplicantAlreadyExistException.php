<?php declare(strict_types = 1);

namespace AlertBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AlertBundle\Exceptions
 */
class ApplicantAlreadyExistException extends Exception
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

        parent::__construct(sprintf("Applicant with email: %s already exists", $email));
    }
}
