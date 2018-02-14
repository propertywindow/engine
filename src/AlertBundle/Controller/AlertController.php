<?php
declare(strict_types = 1);

namespace AlertBundle\Controller;

use AlertBundle\Service\Alert\Mapper;
use AppBundle\Controller\JsonController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AlertBundle\Exceptions\AlertNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AlertBundle\Controller\AlertController")
 */
class AlertController extends JsonController
{
    /**
     * @Route("/alert" , name="alert")
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
     * @throws AlertNotFoundException
     * @throws NotAuthorizedException
     */
    private function getAlert(): array
    {
        $this->checkParameters(['id']);

        $alert = $this->alertService->getAlert((int)$this->parameters['id']);

        $this->isAuthorized(
            $this->user->getAgent()->getAgentGroup()->getId(),
            $alert->getApplicant()->getAgentGroup()->getId()
        );

        return Mapper::fromAlert($alert);
    }

    /**
     * @return array
     */
    private function getAlerts(): array
    {
        return Mapper::fromAlerts(...$this->alertService->getAlerts($this->user->getAgent()->getAgentGroup()));
    }
}
