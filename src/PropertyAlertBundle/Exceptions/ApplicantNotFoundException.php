<?php declare(strict_types=1);

namespace PropertyAlertBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package PropertyAlertBundle\Exceptions
 */
class ApplicantNotFoundException extends Exception
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

        parent::__construct(sprintf("Could not find applicant with id: %d", $id));
    }
}
