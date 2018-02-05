<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
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
     * @throws UserSettingsNotFoundException
     */
    private function getSettings()
    {
        return Mapper::fromUserSettings($this->userSettingsService->getSettings($this->user));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserSettingsNotFoundException
     */
    private function updateSettings(array $parameters)
    {
        $settings = $this->userSettingsService->getSettings($this->user);

        if ($settings->getId() !== $this->user->getId()) {
            if ($this->user->getUserType()->getId() !== self::USER_ADMIN) {
                throw new NotAuthorizedException();
            }
        }

        $this->prepareParameters($settings, $parameters);

        return Mapper::fromUserSettings($this->userSettingsService->updateSettings($settings));
    }
}
