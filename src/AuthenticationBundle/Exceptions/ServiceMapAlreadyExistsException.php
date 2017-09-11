<?php declare(strict_types=1);

namespace AuthenticationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AuthenticationBundle\Exceptions
 */
class ServiceMapAlreadyExistsException extends Exception
{
    /**
     * @var int
     */
    private $service;

    /**
     * @param int    $service
     *
     * @internal param string $id
     */
    public function __construct(int $service)
    {
        $this->service  = $service;

        parent::__construct(sprintf("service map already has service with id: %d", $service));
    }
}
