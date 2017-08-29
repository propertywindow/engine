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
use LogBundle\Service\ActivityService;
use LogBundle\Service\TrafficService;
use PropertyBundle\Exceptions\PropertyNotFoundException;
use PropertyBundle\Exceptions\PropertyAlreadyExistsException;
use PropertyBundle\Service\PropertyService;
use PropertyBundle\Service\Property\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="property_controller")
 */
class PropertyController extends Controller
{
    private const         PARSE_ERROR            = -32700;
    private const         INVALID_REQUEST        = -32600;
    private const         METHOD_NOT_FOUND       = -32601;
    private const         INVALID_PARAMS         = -32602;
    private const         INTERNAL_ERROR         = -32603;
    private const         USER_NOT_AUTHENTICATED = -32000;
    private const         PROPERTY_NOT_FOUND     = -32001;
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
     * @var ActivityService
     */
    private $activityService;

    /**
     * @var TrafficService
     */
    private $trafficService;

    /**
     * @param Authenticator   $authenticator
     * @param PropertyService $propertyService
     * @param UserService     $userService
     * @param AgentService    $agentService
     * @param ActivityService $activityService
     * @param TrafficService  $trafficService
     */
    public function __construct(
        Authenticator $authenticator,
        PropertyService $propertyService,
        UserService $userService,
        AgentService $agentService,
        ActivityService $activityService,
        TrafficService $trafficService
    ) {
        $this->authenticator   = $authenticator;
        $this->propertyService = $propertyService;
        $this->userService     = $userService;
        $this->agentService    = $agentService;
        $this->activityService = $activityService;
        $this->trafficService  = $trafficService;
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
            case "createProperty":
                return $this->createProperty($userId, $parameters);
            case "updateProperty":
                return $this->updateProperty($userId, $parameters);
            case "archiveProperty":
                return $this->archiveProperty($userId, $parameters);
            case "deleteProperty":
                return $this->deleteProperty($userId, $parameters);
            case "setPropertySold":
                return $this->setPropertySold($userId, $parameters);
            case "toggleOnline":
                return $this->toggleOnline($userId, $parameters);
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

        $id   = (int)$parameters['id'];
        $user = $this->userService->getUser($userId);

        $property = $this->propertyService->getProperty($id);

        if ($property->getAgent()->getId() !== $user->getAgentId()) {
            throw new NotAuthorizedException($userId);
        }

        if ($user->getTypeId() === self::USER_API) {
            if (!array_key_exists('ip', $parameters)) {
                throw new InvalidArgumentException("No ip argument provided");
            }
            if (!array_key_exists('browser', $parameters)) {
                throw new InvalidArgumentException("No browser argument provided");
            }
            if (!array_key_exists('location', $parameters)) {
                throw new InvalidArgumentException("No location argument provided");
            }

            $this->trafficService->createTraffic(
                $id,
                (string)$parameters['id'],
                (string)$parameters['browser'],
                (string)$parameters['location'],
                (string)$parameters['referrer']
            );
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
        $user  = $this->userService->getUser($userId);
        $agent = $this->agentService->getAgent((int)$user->getAgentId());

        return Mapper::fromProperties(...$this->propertyService->listProperties($agent->getId()));
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
                  $parameters['limit'] !== null ? (int)$parameters['limit'] : 50;
        $offset = array_key_exists('offset', $parameters) &&
                  $parameters['offset'] !== null ? (int)$parameters['offset'] : 0;

        $user     = $this->userService->getUser($userId);
        $agent    = $this->agentService->getAgent((int)$user->getAgentId());
        $agentIds = $this->agentService->getAgentIdsFromGroup((int)$agent->getId());

        list($properties, $count) = $this->propertyService->listAllProperties($agentIds, $limit, $offset);

        return [
            'properties' => Mapper::fromProperty(...$properties),
            'count'      => $count,
        ];
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $property
     *
     * @throws NotAuthorizedException
     * @throws PropertyAlreadyExistsException
     */
    private function createProperty(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if ($user->getTypeId() === self::USER_CLIENT || $user->getTypeId() === self::USER_API) {
            throw new NotAuthorizedException($userId);
        }

        if (!array_key_exists('client_id', $parameters) && $parameters['client_id'] !== null) {
            throw new InvalidArgumentException("client_id parameter not provided");
        }
        if (!array_key_exists('kind', $parameters) && $parameters['kind'] !== null) {
            throw new InvalidArgumentException("kind parameter not provided");
        }
        if (!array_key_exists('sub_type_id', $parameters) && $parameters['sub_type_id'] !== null) {
            throw new InvalidArgumentException("sub_type_id parameter not provided");
        }
        if (!array_key_exists('street', $parameters) && $parameters['street'] !== null) {
            throw new InvalidArgumentException("street parameter not provided");
        }
        if (!array_key_exists('house_number', $parameters) && $parameters['house_number'] !== null) {
            throw new InvalidArgumentException("house_number parameter not provided");
        }
        if (!array_key_exists('postcode', $parameters) && $parameters['postcode'] !== null) {
            throw new InvalidArgumentException("postcode parameter not provided");
        }
        if (!array_key_exists('city', $parameters) && $parameters['city'] !== null) {
            throw new InvalidArgumentException("city parameter not provided");
        }
        if (!array_key_exists('country', $parameters) && $parameters['country'] !== null) {
            throw new InvalidArgumentException("country parameter not provided");
        }
        if (!array_key_exists('lat', $parameters) && $parameters['lat'] !== null) {
            throw new InvalidArgumentException("lat parameter not provided");
        }
        if (!array_key_exists('lng', $parameters) && $parameters['lng'] !== null) {
            throw new InvalidArgumentException("lng parameter not provided");
        }

        if ($this->propertyService->checkExistence($parameters)) {
            throw new PropertyAlreadyExistsException($parameters['client_id']);
        }

        $agent      = $this->agentService->getAgent((int)$user->getAgentId());
        $property   = $this->propertyService->createProperty($parameters, $agent);
        $propertyId = (int)$property->getId();

        $this->activityService->createActivity(
            $userId,
            $propertyId,
            'property',
            'create',
            null,
            $this->get('jms_serializer')->serialize($property, 'json')
        );

        // todo: also insert Details, Gallery, GeneralNotes
        // todo: create data folder

        return Mapper::fromProperty($property);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function updateProperty(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters) || empty($parameters['id'])) {
            throw new InvalidArgumentException("Identifier not provided");
        }

        $user     = $this->userService->getUser($userId);
        $id       = (int)$parameters['id'];
        $property = $this->propertyService->getProperty($id);

        if ($property->getAgent()->getId() !== $user->getAgentId()) {
            throw new NotAuthorizedException($userId);
        }

        if (array_key_exists('client_id', $parameters) && $parameters['client_id'] !== null) {
            $property->setClientId((int)$parameters['client_id']);
        }

        if (array_key_exists('kind', $parameters) && $parameters['kind'] !== null) {
            $property->setKind((string)$parameters['kind']);
        }

        if (array_key_exists('sub_type_id', $parameters) && $parameters['sub_type_id'] !== null) {
            $property->setSubType((int)$parameters['sub_type_id']);
        }

        if (array_key_exists('terms', $parameters) && $parameters['terms'] !== null) {
            $property->setTerms((int)$parameters['terms']);
        }

        if (array_key_exists('online', $parameters) && $parameters['online'] !== null) {
            $property->setOnline((int)$parameters['online']);
        }

        if (array_key_exists('street', $parameters) && $parameters['street'] !== null) {
            $property->setStreet((string)$parameters['street']);
        } else {
            throw new InvalidArgumentException("street parameter not provided");
        }

        if (array_key_exists('house_number', $parameters) && $parameters['house_number'] !== null) {
            $property->setHouseNumber((string)$parameters['house_number']);
        } else {
            throw new InvalidArgumentException("house_number parameter not provided");
        }

        if (array_key_exists('postcode', $parameters) && $parameters['postcode'] !== null) {
            $property->setPostcode((string)$parameters['postcode']);
        } else {
            throw new InvalidArgumentException("postcode parameter not provided");
        }

        if (array_key_exists('city', $parameters) && $parameters['city'] !== null) {
            $property->setCity((string)$parameters['city']);
        } else {
            throw new InvalidArgumentException("city parameter not provided");
        }

        if (array_key_exists('country', $parameters) && $parameters['country'] !== null) {
            $property->setCountry((string)$parameters['country']);
        } else {
            throw new InvalidArgumentException("country parameter not provided");
        }

        if (array_key_exists('price', $parameters) && $parameters['price'] !== null) {
            $property->setPrice((int)$parameters['price']);
        }

        if (array_key_exists('espc', $parameters) && $parameters['espc'] !== null) {
            $property->setEspc((bool)$parameters['espc']);
        }

        if (array_key_exists('lat', $parameters) && $parameters['lat'] !== null) {
            $property->setLat((string)$parameters['lat']);
        } else {
            throw new InvalidArgumentException("lat parameter not provided");
        }

        if (array_key_exists('lng', $parameters) && $parameters['lng'] !== null) {
            $property->setLng((string)$parameters['lng']);
        } else {
            throw new InvalidArgumentException("lng parameter not provided");
        }

        $updatedProperty = $this->propertyService->updateProperty($property);

        $this->activityService->createActivity(
            $userId,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );

        return Mapper::fromProperty($updatedProperty);

        // todo: also update Details, Gallery, GeneralNotes
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function archiveProperty(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id       = (int)$parameters['id'];
        $user     = $this->userService->getUser($userId);
        $property = $this->propertyService->getProperty($id);

        if ($property->getAgent()->getId() !== $user->getAgentId()) {
            throw new NotAuthorizedException($userId);
        }

        $this->propertyService->archiveProperty($id);

        $this->activityService->createActivity(
            $userId,
            $id,
            'property',
            'archive',
            null,
            $this->get('jms_serializer')->serialize($property, 'json')
        );

        // todo: remove all photos apart from main from data folder and Gallery
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function deleteProperty(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id   = (int)$parameters['id'];
        $user = $this->userService->getUser($userId);

        if ((int)$user->getTypeId() === self::USER_ADMIN || self::USER_AGENT) {
            $this->propertyService->deleteProperty($id);
        } else {
            throw new NotAuthorizedException($userId);
        }

        // todo: delete info from not cascading tables too, including logBundle
        // todo: remove all photos from data folder and Gallery
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function setPropertySold(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if (!array_key_exists('soldPrice', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id        = (int)$parameters['id'];
        $soldPrice = (int)$parameters['soldPrice'];
        $user      = $this->userService->getUser($userId);
        $property  = $this->propertyService->getProperty($id);

        if ($property->getAgent()->getId() !== $user->getAgentId()) {
            throw new NotAuthorizedException($userId);
        }

        $updatedProperty = $this->propertyService->setPropertySold($id, $soldPrice);

        $this->activityService->createActivity(
            $userId,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function toggleOnline(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if (!array_key_exists('online', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id       = (int)$parameters['id'];
        $online   = (bool)$parameters['online'];
        $user     = $this->userService->getUser($userId);
        $property = $this->propertyService->getProperty($id);

        if ($property->getAgent()->getId() !== $user->getAgentId()) {
            throw new NotAuthorizedException($userId);
        }

        $updatedProperty = $this->propertyService->toggleOnline($id, $online);

        $this->activityService->createActivity(
            $userId,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );
    }
}
