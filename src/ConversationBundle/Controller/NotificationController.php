<?php
declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
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
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param int    $userId
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     * @throws NotificationNotFoundException
     * @throws UserNotFoundException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getNotifications":
                return $this->getNotifications($userId);
            case "getNotification":
                return $this->getNotification($parameters);
            case "listNotifications":
                return $this->listNotifications($userId);
            case "createNotification":
                return $this->createNotification($userId, $parameters);
            case "updateNotification":
                return $this->updateNotification($parameters);
            case "deleteNotification":
                return $this->deleteNotification($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function getNotifications(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromNotifications(...$this->notificationService->getNotifications($user));
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
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function listNotifications(int $userId)
    {
        $user          = $this->userService->getUser($userId);
        $notifications = $this->notificationService->listNotifications($user);

        return Mapper::fromNotifications(...$notifications);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws UserNotFoundException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createNotification(int $userId, array $parameters)
    {
        // todo: check rights

        $this->checkParameters([
            'content',
            'type',
            'start',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        $notification = new Notification();
        $notification->setUser($user);

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
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws NotificationNotFoundException
     * @throws UserNotFoundException
     */
    private function deleteNotification(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        // todo: check rights
        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $id = (int)$parameters['id'];

        $this->notificationService->deleteNotification($id);
    }
}
