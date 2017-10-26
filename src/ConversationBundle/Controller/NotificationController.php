<?php declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use ConversationBundle\Entity\Notification;
use DateTime;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use ConversationBundle\Service\Notification\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="notification_controller")
 */
class NotificationController extends BaseController
{
    /**
     * @Route("/notification" , name="notification")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     */
    public function requestHandler(Request $httpRequest)
    {
        $id = null;
        try {
            list($id, $userId, $method, $parameters) = $this->prepareRequest($httpRequest);

            $jsonRpcResponse = Response::success($id, $this->invoke($userId, $method, $parameters));
        } catch (CouldNotParseJsonRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::PARSE_ERROR, $ex->getMessage()));
        } catch (InvalidJsonRpcRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_REQUEST, $ex->getMessage()));
        } catch (InvalidJsonRpcMethodException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::METHOD_NOT_FOUND, $ex->getMessage()));
        } catch (InvalidArgumentException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_PARAMS, $ex->getMessage()));
        } catch (CouldNotAuthenticateUserException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::USER_NOT_AUTHENTICATED, $ex->getMessage()));
        } catch (NotificationNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::NOTIFICATION_NOT_FOUND, $ex->getMessage()));
        } catch (Exception $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INTERNAL_ERROR, $ex->getMessage()));
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
     * @throws NotificationNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
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
                return $this->updateNotification($userId, $parameters);
            case "deleteNotification":
                return $this->deleteNotification($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int $userId
     *
     * @return array
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
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromNotification($this->notificationService->getNotification($id));
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    private function listNotifications(int $userId)
    {
        $user = $this->userService->getUser($userId);
        $notifications = $this->notificationService->listNotifications($user);

        return Mapper::fromNotifications(...$notifications);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function createNotification(int $userId, array $parameters)
    {
        // todo: check rights

        $user = $this->userService->getUser($userId);

        $notification = new Notification();

        $notification->setUser($user);

        if (!array_key_exists('content', $parameters) && $parameters['content'] !== null) {
            throw new InvalidArgumentException("Content parameter not provided");
        } else {
            $notification->setContent((string)$parameters['content']);
        }

        if (!array_key_exists('type', $parameters) && $parameters['type'] !== null) {
            throw new InvalidArgumentException("Type parameter not provided");
        } else {
            $notification->setType((string)$parameters['type']);
        }

        if (!array_key_exists('start', $parameters) && $parameters['start'] !== null) {
            throw new InvalidArgumentException("Start parameter not provided");
        }

        $start = DateTime::createFromFormat("Y-m-d H:i:s", $parameters['start']);
        if ($start === false) {
            throw new InvalidArgumentException("Start {$parameters['start']} couldn't be parsed");
        } else {
            $notification->setStart($start);
        }

        if (array_key_exists('end', $parameters) && $parameters['end'] !== null) {
            $end = DateTime::createFromFormat("Y-m-d H:i:s", $parameters['end']);
            if ($end === false) {
                throw new InvalidArgumentException("End {$parameters['end']} couldn't be parsed");
            }
            $notification->setEnd($end);
        }

        if (array_key_exists('label', $parameters)) {
            $notification->setLabel((string)$parameters['label']);
        }

        if (array_key_exists('visible', $parameters) && $parameters['visible'] !== null) {
            $notification->setVisible((bool)$parameters['visible']);
        }

        if (array_key_exists('important', $parameters) && $parameters['important'] !== null) {
            $notification->setImportant((bool)$parameters['important']);
        }

        if (array_key_exists('removable', $parameters) && $parameters['removable'] !== null) {
            $notification->setRemovable((bool)$parameters['removable']);
        }

        $userIdentifiers = [];

        if (array_key_exists('userIdentifiers', $parameters) && is_array($parameters['userIdentifiers'])) {
            $userIdentifiers = array_map('intval', $parameters['userIdentifiers']);
        }

        return Mapper::fromNotification(
            $this->notificationService->createNotification($notification, $userIdentifiers)
        );
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     */
    private function updateNotification(int $userId, array $parameters)
    {
        // todo: check rights

        $user = $this->userService->getUser($userId);

        if (!array_key_exists('id', $parameters) || empty($parameters['id'])) {
            throw new InvalidArgumentException("Identifier not provided");
        }
        $notification = $this->notificationService->getNotification((int)$parameters['id']);

        if (array_key_exists('content', $parameters) && $parameters['content'] !== null) {
            $notification->setContent((string)$parameters['content']);
        }

        if (array_key_exists('type', $parameters) && $parameters['type'] !== null) {
            $notification->setType((string)$parameters['type']);
        }

        if (array_key_exists('start', $parameters) && $parameters['start'] !== null) {
            $start = DateTime::createFromFormat("Y-m-d H:i:s", $parameters['start']);
            if ($start === false) {
                throw new InvalidArgumentException("Start {$parameters['start']} couldn't be parsed");
            }
            $notification->setStart($start);
        }

        if (array_key_exists('end', $parameters) && $parameters['end'] !== null) {
            $end = DateTime::createFromFormat("Y-m-d H:i:s", $parameters['end']);
            if ($end === false) {
                throw new InvalidArgumentException("End {$parameters['end']} couldn't be parsed");
            }
            $notification->setEnd($end);
        }

        if (array_key_exists('label', $parameters)) {
            $notification->setLabel($parameters['label'] !== null ? (string)$parameters['label'] : null);
        }

        if (array_key_exists('visible', $parameters)) {
            $notification->setVisible((bool)$parameters['visible']);
        }

        if (array_key_exists('important', $parameters)) {
            $notification->setImportant((bool)$parameters['important']);
        }

        if (array_key_exists('removable', $parameters) && $parameters['removable'] !== null) {
            $notification->setRemovable((bool)$parameters['removable']);
        }

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
     */
    private function deleteNotification(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user = $this->userService->getUser($userId);

        // todo: check rights

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $id = (int)$parameters['id'];

        $this->notificationService->deleteNotification($id);
    }
}
