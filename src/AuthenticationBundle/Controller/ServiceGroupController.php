<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Service\ServiceGroup\Mapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\ServiceGroupController")
 */
class ServiceGroupController extends BaseController
{
    /**
     * @Route("/services/service_group" , name="service_group")
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
     * @throws ServiceGroupNotFoundException
     * @throws UserNotFoundException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getServiceGroup":
                return $this->getServiceGroup($userId, $parameters);
            case "getServiceGroups":
                return $this->getServiceGroups($userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws ServiceGroupNotFoundException
     * @throws UserNotFoundException
     */
    private function getServiceGroup(int $userId, array $parameters): array
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user         = $this->userService->getUser($userId);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$parameters['id']);

        return Mapper::fromServiceGroup($user->getSettings()->getLanguage(), $serviceGroup);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function getServiceGroups(int $userId): array
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromServiceGroups($user->getSettings()->getLanguage(), ...
            $this->serviceGroupService->getServiceGroups());
    }
}
