<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use AuthenticationBundle\Service\ServiceService;
use AuthenticationBundle\Service\Service\Mapper;
use AuthenticationBundle\Service\UserService;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Security\Authenticator;
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
class ServiceController extends Controller
{
    private const         PARSE_ERROR            = -32700;
    private const         INVALID_REQUEST        = -32600;
    private const         METHOD_NOT_FOUND       = -32601;
    private const         INVALID_PARAMS         = -32602;
    private const         INTERNAL_ERROR         = -32603;
    private const         USER_NOT_AUTHENTICATED = -32000;
    private const         SERVICE_NOT_FOUND      = -32001;
    private const         USER_ADMIN             = 1;
    private const         USER_AGENT             = 2;
    private const         USER_COLLEAGUE         = 3;
    private const         USER_CLIENT            = 4;
    private const         USER_API               = 5;

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var ServiceService
     */
    private $serviceService;

    /**
     * @var UserService
     */
    private $userService;


    /**
     * @param Authenticator  $authenticator
     * @param ServiceService $serviceService
     * @param UserService    $userService
     */
    public function __construct(
        Authenticator $authenticator,
        ServiceService $serviceService,
        UserService $userService
    ) {
        $this->authenticator  = $authenticator;
        $this->serviceService = $serviceService;
        $this->userService    = $userService;
    }

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
            $userId = $this->authenticator->authenticate($httpRequest);

            $jsonString = file_get_contents('php://input');
            $jsonArray  = json_decode($jsonString, true);

            if ($jsonArray === null) {
                throw new CouldNotParseJsonRequestException("Could not parse JSON-RPC request");
            }

            if ($jsonArray['jsonrpc'] !== '2.0') {
                throw new InvalidJsonRpcRequestException("Request does not match JSON-RPC 2.0 specification");
            }

            $id     = $jsonArray['id'];
            $method = $jsonArray['method'];
            if (empty($method)) {
                throw new InvalidJsonRpcMethodException("No request method found");
            }

            $parameters = [];
            if (array_key_exists('params', $jsonArray)) {
                $parameters = $jsonArray['params'];
            }

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

        $httpResponse = HttpResponse::create(
            json_encode($jsonRpcResponse),
            200,
            [
                'Content-Type' => 'application/json',
            ]
        );

        return $httpResponse;
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
            case "getServiceGroup":
                return $this->getServiceGroup($parameters);
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

        $id      = (int)$parameters['id'];
        $user    = $this->userService->getUser($userId);
        $service = $this->serviceService->getService($id);

        return Mapper::fromService($service);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getServiceGroup(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id           = (int)$parameters['id'];
        $serviceGroup = $this->serviceService->getServiceGroup($id);

        return Mapper::fromServiceGroup($serviceGroup);
    }
}
