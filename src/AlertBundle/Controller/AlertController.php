<?php
declare(strict_types=1);

namespace AlertBundle\Controller;

use AlertBundle\Service\Alert\Mapper;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
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
class AlertController extends BaseController
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
     * @throws AlertNotFoundException
     * @throws NotAuthorizedException
     */
    private function getAlert(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $id    = (int)$parameters['id'];
        $alert = $this->alertService->getAlert($id);

        $this->isAuthorized(
            $user->getAgent()->getAgentGroup()->getId(),
            $alert->getApplicant()->getAgentGroup()->getId()
        );

        return Mapper::fromAlert($alert);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function getAlerts(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromAlerts(...$this->alertService->getAlerts($user->getAgent()->getAgentGroup()));
    }
}
