<?php
declare(strict_types = 1);

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 */
class ExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $responseData = [
            'error' => [
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
            ],
        ];

        $event->setResponse(new JsonResponse($responseData, 400));
    }
}
