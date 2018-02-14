<?php declare(strict_types = 1);

namespace AlertBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AlertBundle\Exceptions
 */
class ApplicationNotFoundException extends Exception
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

        parent::__construct(sprintf("Could not find application with id: %d", $id));
    }
}
