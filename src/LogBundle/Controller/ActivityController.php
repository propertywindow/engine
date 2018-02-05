<?php
declare(strict_types=1);

namespace LogBundle\Controller;

use AgentBundle\Exceptions\AgentNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use LogBundle\Exceptions\ActivityNotFoundException;
use LogBundle\Service\Activity\Mapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="LogBundle\Controller\ActivityController")
 */
class ActivityController extends BaseController
{
    /**
     * @Route("/log/activity" , name="activity_log")
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
     * @param array $parameters
     *
     * @return array
     * @throws ActivityNotFoundException
     * @throws NotAuthorizedException
     */
    private function getActivity(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        return Mapper::fromActivity($this->logActivityService->getActivity((int)$parameters['id']));
    }

    /**
     * @return array
     */
    private function getActivityFromUser()
    {
        return Mapper::fromActivities(...$this->logActivityService->getActivityFromUser($this->user));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getActivities()
    {
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        return Mapper::fromActivities(...$this->logActivityService->getActivities($this->user->getAgent()));
    }


    /**
     * @param array $parameters
     *
     * @return array
     * @throws AgentNotFoundException
     */
    private function getPropertyChanges(array $parameters)
    {
        $this->checkParameters([
            'type',
        ], $parameters);

        if (array_key_exists('id', $parameters) && $parameters['id'] !== null) {
            $agent = $this->agentService->getAgent($parameters['id']);
        } else {
            $agent = $this->user->getAgent();
        }

        switch ($parameters['type']) {
            case "create":
                $activities = $this->logActivityService->findPropertiesByAgent($agent, $parameters['type']);
                break;
            case "update":
                $activities = $this->logActivityService->findPropertiesByAgent($agent, $parameters['type']);
                break;
            default:
                $activities = $this->logActivityService->findPropertiesByAgent($agent, 'create');
        }

        return Mapper::fromActivities(...$activities);
    }
}
