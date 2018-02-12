<?php
declare(strict_types = 1);

namespace AppBundle\EventListener;

use AppBundle\Exceptions\PublishedMessageException;
use AppBundle\Exceptions\UserInputException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class PublishedMessageExceptionListener
 */
class PublishedMessageExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof PublishedMessageException) {
            return;
        }
        $code = $exception instanceof UserInputException ? 400 : 500;

        $responseData = [
            'error' => [
                'code'    => $code,
                'message' => $exception->getMessage(),
            ],
        ];

        $event->setResponse(new JsonResponse($responseData, $code));
    }
}
