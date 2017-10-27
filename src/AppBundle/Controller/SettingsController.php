<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AppBundle\Exceptions\SettingsNotFoundException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Service\Settings\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="settings_controller")
 */
class SettingsController extends BaseController
{
    /**
     * @Route("/settings" , name="settings")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
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
     *
     * @throws InvalidJsonRpcMethodException
     * @throws SettingsNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getSettings":
                return $this->getSettings();
            case "updateSettings":
                return $this->updateSettings($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @return array
     *
     * @throws SettingsNotFoundException
     */
    private function getSettings()
    {
        return Mapper::fromSettings($this->settingsService->getSettings());
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function updateSettings(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $settings = $this->settingsService->getSettings();

        if (!array_key_exists('application_name', $parameters)) {
            throw new InvalidArgumentException("application_name parameter not provided");
        }

        if (!array_key_exists('application_url', $parameters)) {
            throw new InvalidArgumentException("application_url parameter not provided");
        }

        if (!array_key_exists('max_failed_login', $parameters)) {
            throw new InvalidArgumentException("max_failed_login parameter not provided");
        }

        $settings->setApplicationName((string)$parameters['application_name']);
        $settings->setApplicationURL((string)$parameters['application_url']);
        $settings->setMaxFailedLogin((int)$parameters['max_failed_login']);


        return Mapper::fromSettings($this->settingsService->updateSettings($settings));
    }
}
