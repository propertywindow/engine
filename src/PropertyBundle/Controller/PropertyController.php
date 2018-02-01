<?php
declare(strict_types=1);

namespace PropertyBundle\Controller;

use AgentBundle\Exceptions\ClientNotFoundException;
use AppBundle\Controller\BaseController;

use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use InvalidArgumentException;
use PropertyBundle\Entity\Property;
use PropertyBundle\Exceptions\KindNotFoundException;
use PropertyBundle\Exceptions\SubTypeNotFoundException;
use PropertyBundle\Exceptions\TermsNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use PropertyBundle\Exceptions\PropertyNotFoundException;
use PropertyBundle\Exceptions\PropertyAlreadyExistsException;
use PropertyBundle\Service\Property\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="PropertyBundle\Controller\PropertyController")
 */
class PropertyController extends BaseController
{
    /**
     * @Route("/property" , name="property")
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
     * @throws ClientNotFoundException
     * @throws InvalidJsonRpcMethodException
     * @throws KindNotFoundException
     * @throws NotAuthorizedException
     * @throws PropertyAlreadyExistsException
     * @throws PropertyNotFoundException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    public function invoke(int $userId, string $method, array $parameters = [])
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
     * @throws PropertyNotFoundException
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    private function getProperty(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id           = (int)$parameters['id'];
        $user         = $this->userService->getUser($userId);
        $userSettings = $this->userSettingsService->getSettings($user);

        $property = $this->propertyService->getProperty($id);

        $this->isAuthorized($property->getAgent()->getId(), $user->getAgent()->getId());

        if ($user->getUserType()->getId() === self::USER_API) {
            $required = [
                'ip',
                'browser',
                'location',
            ];

            $this->checkParameters($required, $parameters);

            $this->logTrafficService->createTraffic(
                $id,
                (string)$parameters['id'],
                (string)$parameters['browser'],
                (string)$parameters['location'],
                (string)$parameters['referrer']
            );
        }

        return Mapper::fromProperty($userSettings->getLanguage(), $property);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    private function getProperties(int $userId)
    {
        $user         = $this->userService->getUser($userId);
        $userSettings = $this->userSettingsService->getSettings($user);

        return Mapper::fromProperties($userSettings->getLanguage(), ...
            $this->propertyService->listProperties($user->getAgent()->getId()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    private function getAllProperties(int $userId, array $parameters)
    {
        $limit  = array_key_exists('limit', $parameters) &&
                  $parameters['limit'] !== null ? (int)$parameters['limit'] : 50;
        $offset = array_key_exists('offset', $parameters) &&
                  $parameters['offset'] !== null ? (int)$parameters['offset'] : 0;

        $user         = $this->userService->getUser($userId);
        $userSettings = $this->userSettingsService->getSettings($user);
        $agentIds     = $this->agentService->getAgentIdsFromGroup($user->getAgent());

        list($properties, $count) = $this->propertyService->listAllProperties($agentIds, $limit, $offset);

        return [
            'properties' => Mapper::fromProperties($userSettings->getLanguage(), ...$properties),
            'count'      => $count,
        ];
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $property
     * @throws NotAuthorizedException
     * @throws PropertyAlreadyExistsException
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     * @throws ClientNotFoundException
     * @throws KindNotFoundException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     */
    private function createProperty(int $userId, array $parameters)
    {
        $user         = $this->userService->getUser($userId);
        $userSettings = $this->userSettingsService->getSettings($user);

        if ($user->getUserType()->getId() === self::USER_CLIENT || $user->getUserType()->getId() === self::USER_API) {
            throw new NotAuthorizedException($userId);
        }

        $this->checkParameters([
            'client_id',
            'kind_id',
            'sub_type_id',
            'terms_id',
            'street',
            'house_number',
            'postcode',
            'city',
            'country',
            'lat',
            'lng',
        ], $parameters);

        if ($this->propertyService->checkExistence($parameters)) {
            throw new PropertyAlreadyExistsException($parameters['client_id']);
        }

        $property = new Property();

        $property->setKind($this->kindService->getKind($parameters['kind_id']));
        $property->setTerms($this->termsService->getTerm($parameters['terms_id']));
        $property->setAgent($user->getAgent());
        $property->setClient($this->clientService->getClient($parameters['client_id']));
        $property->setSubType($this->subTypeService->getSubType($parameters['sub_type_id']));
        $property->setStreet(ucwords($parameters['street']));
        $property->setHouseNumber($parameters['house_number']);
        $property->setPostcode($parameters['postcode']);
        $property->setCity(ucwords($parameters['city']));
        $property->setCountry($parameters['country']);
        $property->setLat($parameters['lat']);
        $property->setLng($parameters['lng']);

        if (array_key_exists('online', $parameters) && $parameters['online'] !== null) {
            $property->setOnline((bool)$parameters['online']);
        }
        if (array_key_exists('price', $parameters) && $parameters['price'] !== null) {
            $property->setPrice((int)$parameters['price']);
        }
        if (array_key_exists('espc', $parameters) && $parameters['espc'] !== null) {
            $property->setEspc((bool)$parameters['espc']);
        }

        $this->propertyService->createProperty($property);

        $propertyId = (int)$property->getId();

        $this->logActivityService->createActivity(
            $user,
            $propertyId,
            'property',
            'create',
            null,
            $this->get('jms_serializer')->serialize($property, 'json')
        );

        $this->slackService->info(
            $user->getAgent()->getAgentGroup()->getName() .
            ' (' . $user->getFirstName() .
            ' ' . $user->getLastName() .
            ') added a new property: #' . $propertyId
        );

        // todo: also insert Details, Gallery, GeneralNotes
        // todo: create data folder

        return Mapper::fromProperty($userSettings->getLanguage(), $property);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws ClientNotFoundException
     * @throws KindNotFoundException
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     * @throws UserNotFoundException
     * @throws UserSettingsNotFoundException
     */
    private function updateProperty(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters) || empty($parameters['id'])) {
            throw new InvalidArgumentException("Identifier not provided");
        }

        $id           = (int)$parameters['id'];
        $user         = $this->userService->getUser($userId);
        $userSettings = $this->userSettingsService->getSettings($user);
        $property     = $this->propertyService->getProperty($id);

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
            $subType = $this->subTypeService->getSubType($parameters['sub_type_id']);
            $property->setSubType($subType);
        }

        if (array_key_exists('terms_id', $parameters) && $parameters['terms_id'] !== null) {
            $terms = $this->termsService->getTerm($parameters['terms_id']);
            $property->setTerms($terms);
        }

        if (array_key_exists('online', $parameters) && $parameters['online'] !== null) {
            $property->setOnline((bool)$parameters['online']);
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

        $this->logActivityService->createActivity(
            $user,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );

        return Mapper::fromProperty($userSettings->getLanguage(), $updatedProperty);

        // todo: also update Details, Gallery, GeneralNotes
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     * @throws UserNotFoundException
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

        $this->propertyService->archiveProperty($property);

        $this->logActivityService->createActivity(
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
     * @throws PropertyNotFoundException
     * @throws UserNotFoundException
     */
    private function deleteProperty(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id   = (int)$parameters['id'];
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
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
     * @throws PropertyNotFoundException
     * @throws UserNotFoundException
     * @throws TermsNotFoundException
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

        $term            = $this->termsService->getTerm(9);
        $updatedProperty = $this->propertyService->setPropertySold($id, $soldPrice, $term);

        $this->logActivityService->createActivity(
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
     * @throws PropertyNotFoundException
     * @throws UserNotFoundException
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

        $this->logActivityService->createActivity(
            $user,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );
    }
}
