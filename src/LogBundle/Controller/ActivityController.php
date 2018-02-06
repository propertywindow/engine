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
     * @throws ActivityNotFoundException
     * @throws NotAuthorizedException
     */
    private function getActivity(): array
    {
        $this->checkParameters(['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        return Mapper::fromActivity($this->logActivityService->getActivity((int)$this->parameters['id']));
    }

    /**
     * @return array
     */
    private function getActivityFromUser(): array
    {
        return Mapper::fromActivities(...$this->logActivityService->getActivityFromUser($this->user));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getActivities(): array
    {
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        return Mapper::fromActivities(...$this->logActivityService->getActivities($this->user->getAgent()));
    }


    /**
     * @return array
     * @throws AgentNotFoundException
     */
    private function getPropertyChanges(): array
    {
        $this->checkParameters(['type']);

        if (array_key_exists('id', $this->parameters) && $this->parameters['id'] !== null) {
            $agent = $this->agentService->getAgent($this->parameters['id']);
        } else {
            $agent = $this->user->getAgent();
        }

        switch ($this->parameters['type']) {
            case "create":
                $activities = $this->logActivityService->findPropertiesByAgent($agent, $this->parameters['type']);
                break;
            case "update":
                $activities = $this->logActivityService->findPropertiesByAgent($agent, $this->parameters['type']);
                break;
            default:
                $activities = $this->logActivityService->findPropertiesByAgent($agent, 'create');
        }

        return Mapper::fromActivities(...$activities);
    }
}
