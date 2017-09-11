<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use AuthenticationBundle\Service\Service\Mapper;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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
        $id = null;
        try {
            list($id, $userId, $method, $parameters) = $this->prepareRequest($httpRequest);

            $jsonRpcResponse = Response::success($id, $this->invoke($userId, $method, $parameters));
        } catch (CouldNotParseJsonRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::PARSE_ERROR, $ex->getMessage()));
        } catch (InvalidJsonRpcRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_REQUEST, $ex->getMessage()));
        } catch (InvalidJsonRpcMethodException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::METHOD_NOT_FOUND, $ex->getMessage()));
        } catch (InvalidArgumentException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_PARAMS, $ex->getMessage()));
        } catch (CouldNotAuthenticateUserException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::USER_NOT_AUTHENTICATED, $ex->getMessage()));
        } catch (ServiceNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::SERVICE_NOT_FOUND, $ex->getMessage()));
        } catch (Exception $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INTERNAL_ERROR, $ex->getMessage()));
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
        $service      = $this->serviceService->getService($id);
        $userSettings = $this->userSettingsService->getSettings($userId);

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

        $serviceGroup = $this->serviceGroupService->getServiceGroup($parameters['service_group_id']);
        $userSettings = $this->userSettingsService->getSettings($userId);

        return Mapper::fromServices($userSettings->getLanguage(), ...$this->serviceService->getServices($serviceGroup));
    }
}
