<?php
declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
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
class NotificationController extends BaseController
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
            list($method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(string $method, array $parameters = [])
    {
        if (is_callable([$this, $method])) {
            return $this->$method($parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @return array
     */
    private function getNotifications()
    {
        return Mapper::fromNotifications(...$this->notificationService->getNotifications($this->user));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotificationNotFoundException
     */
    private function getNotification(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        return Mapper::fromNotification($this->notificationService->getNotification((int)$parameters['id']));
    }

    /**
     * @return array
     */
    private function listNotifications()
    {
        return Mapper::fromNotifications(...$this->notificationService->listNotifications($this->user));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createNotification(array $parameters)
    {
        // todo: check rights

        $this->checkParameters([
            'content',
            'type',
            'start',
        ], $parameters);

        $notification = new Notification();
        $notification->setUser($this->user);

        $this->prepareParameters($notification, $parameters);

        $userIdentifiers = [];

        if (array_key_exists('userIdentifiers', $parameters) && is_array($parameters['userIdentifiers'])) {
            $userIdentifiers = array_map('intval', $parameters['userIdentifiers']);
        }

        return Mapper::fromNotification(
            $this->notificationService->createNotification($notification, $userIdentifiers)
        );
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotificationNotFoundException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function updateNotification(array $parameters)
    {
        // todo: check rights

        $this->checkParameters([
            'id',
        ], $parameters);

        $notification = $this->notificationService->getNotification((int)$parameters['id']);

        $this->prepareParameters($notification, $parameters);

        $userIdentifiers = [];

        if (array_key_exists('userIdentifiers', $parameters) && is_array($parameters['userIdentifiers'])) {
            $userIdentifiers = array_map('intval', $parameters['userIdentifiers']);
        }

        return Mapper::fromNotification(
            $this->notificationService->updateNotification($notification, $userIdentifiers)
        );
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws NotificationNotFoundException
     */
    private function deleteNotification(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        // todo: check rights
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $this->notificationService->deleteNotification((int)$parameters['id']);
    }
}
