<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use AuthenticationBundle\Service\Service\Mapper;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="service_controller")
 */
class ServiceController extends BaseController
{
    /**
     * @Route("/services/service" , name="service")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     */
    public function requestHandler(Request $httpRequest)
    {
        try {
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable);
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
     * @throws ServiceNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
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
     * @throws NotAuthorizedException
     */
    private function getService(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id           = (int)$parameters['id'];
        $user         = $this->userService->getUser($userId);
        $service      = $this->serviceService->getService($id);
        $userSettings = $this->userSettingsService->getSettings($user);

        return Mapper::fromService($userSettings->getLanguage(), $service);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getServices(int $userId, array $parameters)
    {
        if (!array_key_exists('service_group_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user         = $this->userService->getUser($userId);
        $serviceGroup = $this->serviceGroupService->getServiceGroup($parameters['service_group_id']);
        $userSettings = $this->userSettingsService->getSettings($user);

        return Mapper::fromServices($userSettings->getLanguage(), ...$this->serviceService->getServices($serviceGroup));
    }
}
