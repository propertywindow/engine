<?php
declare(strict_types = 1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\JsonController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use ConversationBundle\Entity\Notification;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use ConversationBundle\Service\Notification\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="ConversationBundle\Controller\NotificationController")
 */
class NotificationController extends JsonController
{
    /**
     * @Route("/notification" , name="notification")
     * @param Request $httpRequest
     *
     * @return HttpResponse
     * @throws Throwable
     */
    public function requestHandler(Request $httpRequest)
    {
        try {
            $method          = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($method));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param string $method
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(string $method)
    {
        if (is_callable([$this, $method])) {
            return $this->$method();
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @return array
     */
    private function getNotifications(): array
    {
        return Mapper::fromNotifications(...$this->notificationService->getNotifications($this->user));
    }

    /**
     * @return array
     * @throws NotificationNotFoundException
     */
    private function getNotification(): array
    {
        $this->checkParameters(['id']);

        return Mapper::fromNotification($this->notificationService->getNotification((int) $this->parameters['id']));
    }

    /**
     * @return array
     */
    private function listNotifications(): array
    {
        return Mapper::fromNotifications(...$this->notificationService->listNotifications($this->user));
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createNotification(): array
    {
        // todo: check rights

        $this->checkParameters([
            'content',
            'type',
            'start',
        ]);

        $notification = new Notification();
        $notification->setUser($this->user);

        $this->prepareParameters($notification);

        $userIdentifiers = [];

        if (array_key_exists('userIdentifiers', $this->parameters) && is_array($this->parameters['userIdentifiers'])) {
            $userIdentifiers = array_map('intval', $this->parameters['userIdentifiers']);
        }

        return Mapper::fromNotification(
            $this->notificationService->createNotification($notification, $userIdentifiers)
        );
    }

    /**
     * @return array
     * @throws NotificationNotFoundException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function updateNotification(): array
    {
        // todo: check rights

        $this->checkParameters(['id']);

        $notification = $this->notificationService->getNotification((int) $this->parameters['id']);

        $this->prepareParameters($notification);

        $userIdentifiers = [];

        if (array_key_exists('userIdentifiers', $this->parameters) && is_array($this->parameters['userIdentifiers'])) {
            $userIdentifiers = array_map('intval', $this->parameters['userIdentifiers']);
        }

        return Mapper::fromNotification(
            $this->notificationService->updateNotification($notification, $userIdentifiers)
        );
    }

    /**
     * @throws NotAuthorizedException
     * @throws NotificationNotFoundException
     */
    private function deleteNotification()
    {
        $this->checkParameters(['id']);

        // todo: check rights
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $this->notificationService->deleteNotification((int) $this->parameters['id']);
    }
}
