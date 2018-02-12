<?php
declare(strict_types = 1);

namespace AppBundle\Exceptions;

use Exception as BaseException;

/**
 * Class Exception
 */
class Exception extends BaseException implements UserInputException
{
}
