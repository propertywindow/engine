<?php
declare(strict_types = 1);

namespace ConversationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * EmailNotSet Exception
 */
class EmailNotSetException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf("Could not find email settings"));
    }
}
