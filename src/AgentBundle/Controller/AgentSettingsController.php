<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
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
     * @throws AgentSettingsNotFoundException
     */
    private function getSettings()
    {
        return Mapper::fromAgentSettings($this->agentSettingsService->getSettings($this->user->getAgent()));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws AgentSettingsNotFoundException
     */
    private function updateSettings(array $parameters)
    {
        $settings = $this->agentSettingsService->getSettings($this->user->getAgent());

        if ($this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        if ($settings->getAgent()->getId() !== $this->user->getAgent()->getId()) {
            if ($this->user->getUserType()->getId() !== self::USER_ADMIN) {
                throw new NotAuthorizedException();
            }
        }

        $this->prepareParameters($settings, $parameters);

        return Mapper::fromAgentSettings($this->agentSettingsService->updateSettings($settings));
    }
}
