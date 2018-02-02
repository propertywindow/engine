<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Service\Service\Mapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\ServiceController")
 */
class ServiceController extends BaseController
{
    /**
     * @Route("/services/service" , name="service")
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
     * @throws ServiceNotFoundException
     * @throws UserNotFoundException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getService":
                return $this->getService($userId, $parameters);
            case "getServices":
                return $this->getServices($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws ServiceNotFoundException
     * @throws UserNotFoundException
     */
    private function getService(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user    = $this->userService->getUser($userId);
        $service = $this->serviceService->getService((int)$parameters['id']);

        return Mapper::fromService($user->getSettings()->getLanguage(), $service);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws UserNotFoundException
     * @throws ServiceGroupNotFoundException
     */
    private function getServices(int $userId, array $parameters)
    {
        $this->checkParameters([
            'service_group_id',
        ], $parameters);

        $user         = $this->userService->getUser($userId);
        $serviceGroup = $this->serviceGroupService->getServiceGroup($parameters['service_group_id']);

        return Mapper::fromServices($user->getSettings()->getLanguage(), ...
            $this->serviceService->getServices($serviceGroup));
    }
}
