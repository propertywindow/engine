<?php declare(strict_types=1);

namespace LogBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use InvalidArgumentException;
use LogBundle\Exceptions\ActivityNotFoundException;
use LogBundle\Service\Activity\Mapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="activity_controller")
 */
class ActivityController extends BaseController
{
    /**
     * @Route("/log/activity" , name="activity_log")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     *
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
     *
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getActivity":
                return $this->getActivity($userId, $parameters);
            case "getActivityFromUser":
                return $this->getActivityFromUser($userId);
            case "getActivities":
                return $this->getActivities($userId);
            case "getPropertyChanges":
                return $this->getPropertyChanges($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function getActivity(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user = $this->userService->getUser($userId);
        $id   = (int)$parameters['id'];

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromActivity($this->logActivityService->getActivity($id));
    }

    /**
     * @param int $userId
     *
     * @return array
     *
     * @throws ActivityNotFoundException
     */
    private function getActivityFromUser(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromActivities(...$this->logActivityService->getActivityFromUser($user));
    }

    /**
     * @param int $userId
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function getActivities(int $userId)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromActivities(...$this->logActivityService->getActivities($user->getAgent()));
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     */
    private function getPropertyChanges(int $userId, array $parameters)
    {
        if (!array_key_exists('type', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if (array_key_exists('id', $parameters) && $parameters['id'] !== null) {
            $agent = $this->agentService->getAgent($parameters['id']);
        } else {
            $user  = $this->userService->getUser($userId);
            $agent = $user->getAgent();
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
