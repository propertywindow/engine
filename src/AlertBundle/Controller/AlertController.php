<?php
declare(strict_types=1);

namespace AlertBundle\Controller;

use AlertBundle\Service\Alert\Mapper;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use InvalidArgumentException;
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
     * @throws AlertNotFoundException
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getAlert":
                return $this->getAlert($userId, $parameters);
            case "getAlerts":
                return $this->getAlerts($userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws AlertNotFoundException
     * @throws NotAuthorizedException
     */
    private function getAlert(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id    = (int)$parameters['id'];
        $user  = $this->userService->getUser($userId);
        $alert = $this->alertService->getAlert($id);

        if ($user->getAgent()->getAgentGroup() !== $alert->getApplicant()->getAgentGroup()) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromAlert($alert);
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    private function getAlerts(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromAlerts(...$this->alertService->getAlerts($user->getAgent()->getAgentGroup()));
    }
}
