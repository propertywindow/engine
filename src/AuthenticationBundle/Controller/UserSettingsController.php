<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AuthenticationBundle\Service\UserSettings\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\UserSettingsController")
 */
class UserSettingsController extends BaseController
{
    /**
     * @Route("/user_settings" , name="user_settings")
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
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getSettings":
                return $this->getSettings($userId);
            case "updateSettings":
                return $this->updateSettings($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    private function getSettings(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromUserSettings($this->userSettingsService->getSettings($user));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    private function updateSettings(int $userId, array $parameters)
    {
        $user     = $this->userService->getUser($userId);
        $settings = $this->userSettingsService->getSettings($user);

        if ($settings->getId() !== $user->getId()) {
            if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
                throw new NotAuthorizedException();
            }
        }

        $this->convertParameters($settings, $parameters);

        return Mapper::fromUserSettings($this->userSettingsService->updateSettings($settings));
    }
}
