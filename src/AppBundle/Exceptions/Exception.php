<?php declare(strict_types = 1);

namespace AppBundle\Exceptions;

use Exception as BaseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

/**
 * Class Exception
 */
class Exception extends BaseException
{
    /**
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        return new JsonResponse(
            $message,
            $code
        );

    }
}
