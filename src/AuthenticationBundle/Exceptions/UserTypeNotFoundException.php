<?php declare(strict_types=1);

namespace AuthenticationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AuthenticationBundle\Exceptions
 */
class UserTypeNotFoundException extends Exception
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;

        parent::__construct(sprintf("Could not find user type with id: %d", $id));
    }
}
