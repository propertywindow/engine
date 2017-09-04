<?php declare(strict_types=1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\BaseController;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use PropertyBundle\Exceptions\PropertyNotFoundException;
use PropertyBundle\Exceptions\PropertyAlreadyExistsException;
use PropertyBundle\Service\Property\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="property_controller")
 */
class PropertyController extends BaseController
{
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

        if ($property->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        if ($user->getUserType()->getId() === self::USER_API) {
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
     */
    private function getProperties(int $userId)
    {
        $user  = $this->userService->getUser($userId);
        $agent = $this->agentService->getAgent((int)$user->getAgent()->getId());

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
        $agentIds = $this->agentService->getAgentIdsFromGroup((int)$user->getAgent()->getId());

        list($properties, $count) = $this->propertyService->listAllProperties($agentIds, $limit, $offset);

        return [
            'properties' => Mapper::fromProperties(...$properties),
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

        if ($user->getUserType()->getId() === self::USER_CLIENT || $user->getUserType()->getId() === self::USER_API) {
            throw new NotAuthorizedException($userId);
        }

        if (!array_key_exists('client_id', $parameters) && $parameters['client_id'] !== null) {
            throw new InvalidArgumentException("client_id parameter not provided");
        }
        if (!array_key_exists('kind_id', $parameters) && $parameters['kind_id'] !== null) {
            throw new InvalidArgumentException("kind parameter not provided");
        }
        if (!array_key_exists('sub_type_id', $parameters) && $parameters['sub_type_id'] !== null) {
            throw new InvalidArgumentException("sub_type_id parameter not provided");
        }
        if (!array_key_exists('terms_id', $parameters) && $parameters['terms_id'] !== null) {
            throw new InvalidArgumentException("terms_id parameter not provided");
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

        $agent      = $this->agentService->getAgent((int)$user->getAgent()->getId());
        $client     = $this->clientService->getClient($parameters['client_id']);
        $kind       = $this->kindService->getKind($parameters['kind_id']);
        $terms      = $this->termsService->getTerm($parameters['terms_id']);
        $property   = $this->propertyService->createProperty($parameters, $agent, $client, $kind, $terms);
        $propertyId = (int)$property->getId();

        $this->activityService->createActivity(
            $user,
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

        if ($property->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        if (array_key_exists('client_id', $parameters) && $parameters['client_id'] !== null) {
            $client = $this->clientService->getClient($parameters['client_id']);
            $property->setClient($client);
        }

        if (array_key_exists('kind_id', $parameters) && $parameters['kind_id'] !== null) {
            $kind = $this->kindService->getKind($parameters['kind_id']);
            $property->setKind($kind);
        }

        if (array_key_exists('sub_type_id', $parameters) && $parameters['sub_type_id'] !== null) {
            $property->setSubType((int)$parameters['sub_type_id']);
        }

        if (array_key_exists('terms_id', $parameters) && $parameters['terms_id'] !== null) {
            $terms = $this->termsService->getTerm($parameters['terms_id']);
            $property->setTerms($terms);
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
            $user,
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

        if ($property->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        $this->propertyService->archiveProperty($id);

        $this->activityService->createActivity(
            $user,
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

        if ((int)$user->getUserType()->getId() >= self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        $this->propertyService->deleteProperty($id);

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

        if ($property->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        $updatedProperty = $this->propertyService->setPropertySold($id, $soldPrice);

        $this->activityService->createActivity(
            $user,
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

        if ($property->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        $updatedProperty = $this->propertyService->toggleOnline($id, $online);

        $this->activityService->createActivity(
            $user,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );
    }
}
