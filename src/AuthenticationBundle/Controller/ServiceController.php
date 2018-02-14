<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\JsonController;
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
class ServiceController extends JsonController
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
     * @throws ServiceNotFoundException
     */
    private function getService(): array
    {
        $this->checkParameters(['id']);

        $service = $this->serviceService->getService((int)$this->parameters['id']);

        return Mapper::fromService($this->user->getSettings()->getLanguage(), $service);
    }

    /**
     * @return array
     * @throws ServiceGroupNotFoundException
     */
    private function getServices(): array
    {
        $this->checkParameters(['service_group_id']);

        $serviceGroup = $this->serviceGroupService->getServiceGroup($this->parameters['service_group_id']);

        return Mapper::fromServices($this->user->getSettings()->getLanguage(), ...
            $this->serviceService->getServices($serviceGroup));
    }
}
