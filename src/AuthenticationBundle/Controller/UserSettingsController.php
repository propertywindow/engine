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
     * @throws UserSettingsNotFoundException
     */
    private function getSettings(): array
    {
        return Mapper::fromUserSettings($this->userSettingsService->getSettings($this->user));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws UserSettingsNotFoundException
     */
    private function updateSettings(): array
    {
        $settings = $this->userSettingsService->getSettings($this->user);

        if ($settings->getId() !== $this->user->getId()) {
            if ($this->user->getUserType()->getId() !== self::USER_ADMIN) {
                throw new NotAuthorizedException();
            }
        }

        $this->prepareParameters($settings);

        return Mapper::fromUserSettings($this->userSettingsService->updateSettings($settings));
    }
}
