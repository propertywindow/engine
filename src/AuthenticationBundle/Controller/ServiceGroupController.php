<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
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
     * @throws ServiceGroupNotFoundException
     */
    private function getServiceGroup(array $parameters): array
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$parameters['id']);

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
