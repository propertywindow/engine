<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Service\AgentSettings\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AgentBundle\Controller\AgentSettingsController")
 */
class AgentSettingsController extends BaseController
{
    /**
     * @Route("/agent_settings" , name="agent_settings")
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
     * @throws AgentSettingsNotFoundException
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
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
     * @throws AgentSettingsNotFoundException
     * @throws UserNotFoundException
     */
    private function getSettings(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromAgentSettings($this->agentSettingsService->getSettings($user->getAgent()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws AgentSettingsNotFoundException
     * @throws UserNotFoundException
     */
    private function updateSettings(int $userId, array $parameters)
    {
        $user     = $this->userService->getUser($userId);
        $settings = $this->agentSettingsService->getSettings($user->getAgent());

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        if ($settings->getAgent()->getId() !== $user->getAgent()->getId()) {
            if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
                throw new NotAuthorizedException($userId);
            }
        }

        $this->convertParameters($settings, $parameters);


        return Mapper::fromAgentSettings($this->agentSettingsService->updateSettings($settings));
    }
}
