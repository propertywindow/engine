<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\JsonController;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
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
class ServiceGroupController extends JsonController
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
     * @throws ServiceGroupNotFoundException
     */
    private function getServiceGroup(): array
    {
        $this->checkParameters(['id']);

        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$this->parameters['id']);

        return Mapper::fromServiceGroup($this->user->getSettings()->getLanguage(), $serviceGroup);
    }

    /**
     * @return array
     */
    private function getServiceGroups(): array
    {
        return Mapper::fromServiceGroups($this->user->getSettings()->getLanguage(), ...
            $this->serviceGroupService->getServiceGroups());
    }
}
