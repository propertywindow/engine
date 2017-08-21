<?php declare(strict_types=1);

namespace PropertyBundle\Controller;

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
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Service\UserService;
use AgentBundle\Service\AgentService;
use PropertyBundle\Exceptions\PropertyNotFoundException;
use PropertyBundle\Service\PropertyService;
use PropertyBundle\Service\Property\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="property_controller")
 */
class PropertyController extends Controller
{
    private const PARSE_ERROR            = -32700;
    private const INVALID_REQUEST        = -32600;
    private const METHOD_NOT_FOUND       = -32601;
    private const INVALID_PARAMS         = -32602;
    private const INTERNAL_ERROR         = -32603;
    private const USER_NOT_AUTHENTICATED = -32000;
    private const PROPERTY_NOT_FOUND     = -32001;

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var PropertyService
     */
    private $propertyService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var AgentService
     */
    private $agentService;

    /**
     * @param Authenticator   $authenticator
     * @param PropertyService $propertyService
     * @param UserService     $userService
     * @param AgentService    $agentService
     */
    public function __construct(
        Authenticator $authenticator,
        PropertyService $propertyService,
        UserService $userService,
        AgentService $agentService
    ) {
        $this->authenticator   = $authenticator;
        $this->propertyService = $propertyService;
        $this->userService     = $userService;
        $this->agentService    = $agentService;
    }

    /**
     * @Route("/property" , name="property")
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
        } catch (PropertyNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::PROPERTY_NOT_FOUND, $ex->getMessage()));
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
     * @throws PropertyNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getProperty":
                return $this->getProperty($userId, $parameters);
            case "getProperties":
                return $this->getProperties($userId);
            case "getAllProperties":
                return $this->getAllProperties($userId, $parameters);
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
    private function getProperty(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        $user = $this->userService->getUser($userId);

        if ($user->getTypeId() === 5) {
            // set traffic log
        }

        $property = $this->propertyService->getProperty($id);

        if ($property->getAgentId() !== $user->getAgentId()) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromProperty($property);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function getProperties(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromProperties(...$this->propertyService->listProperties((int)$user->getAgentId()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     */
    private function getAllProperties(int $userId, array $parameters)
    {
        $limit  = array_key_exists('limit', $parameters) &&
                  $parameters['limit'] !== null ? (int)$parameters['limit'] : null;
        $offset = array_key_exists('offset', $parameters) &&
                  $parameters['offset'] !== null ? (int)$parameters['offset'] : null;

        $user     = $this->userService->getUser($userId);
        $agentIds = $this->agentService->getAgentIdsFromGroup((int)$user->getAgentId());

        list($properties, $count) = $this->propertyService->listAllProperties($agentIds, $limit, $offset);

        return [
            'properties' => Mapper::fromProperty(...$properties),
            'count'      => $count,
        ];
    }
}
