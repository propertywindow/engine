<?php declare(strict_types=1);

namespace ConversationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package ConversationBundle\Exceptions
 */
class ConversationForRecipientNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf("Could not find conversation"));
    }
}
