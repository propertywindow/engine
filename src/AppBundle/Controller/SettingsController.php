<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AppBundle\Exceptions\SettingsNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Service\Settings\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AppBundle\Controller\SettingsController")
 */
class SettingsController extends BaseController
{
    /**
     * @Route("/settings" , name="settings")
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
     * @throws SettingsNotFoundException
     */
    private function getSettings()
    {
        return Mapper::fromSettings($this->settingsService->getSettings());
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws SettingsNotFoundException
     */
    private function updateSettings()
    {
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $settings = $this->settingsService->getSettings();

        $this->checkParameters([
            'application_name',
            'application_url',
            'max_failed_login',
        ], $this->parameters);

        $this->prepareParameters($settings, $this->parameters);

        return Mapper::fromSettings($this->settingsService->updateSettings($settings));
    }
}
