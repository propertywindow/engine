<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
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
     * @throws ServiceNotFoundException
     */
    private function getService(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $service = $this->serviceService->getService((int)$parameters['id']);

        return Mapper::fromService($this->user->getSettings()->getLanguage(), $service);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws ServiceGroupNotFoundException
     */
    private function getServices(array $parameters)
    {
        $this->checkParameters([
            'service_group_id',
        ], $parameters);

        $serviceGroup = $this->serviceGroupService->getServiceGroup($parameters['service_group_id']);

        return Mapper::fromServices($this->user->getSettings()->getLanguage(), ...
            $this->serviceService->getServices($serviceGroup));
    }
}
