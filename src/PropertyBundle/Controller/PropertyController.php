<?php
declare(strict_types=1);

namespace PropertyBundle\Controller;

use AgentBundle\Exceptions\ClientNotFoundException;
use AppBundle\Controller\BaseController;

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
    public function invoke(string $method, array $parameters = [])
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
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function getProperty(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $property = $this->propertyService->getProperty((int)$parameters['id']);

        $this->isAuthorized($property->getAgent()->getId(), $this->user->getAgent()->getId());

        if ($this->user->getUserType()->getId() === self::USER_API) {
            $this->checkParameters([
                'ip',
                'browser',
                'location',
            ], $parameters);

            $this->logTrafficService->createTraffic(
                $property,
                (string)$parameters['id'],
                (string)$parameters['browser'],
                (string)$parameters['location'],
                (string)$parameters['referrer']
            );
        }

        return Mapper::fromProperty($this->user->getSettings()->getLanguage(), $property);
    }

    /**
     * @return array
     */
    private function getProperties()
    {
        return Mapper::fromProperties($this->user->getSettings()->getLanguage(), ...
            $this->propertyService->listProperties($this->user->getAgent()));
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    private function getAllProperties(array $parameters)
    {
        $limit  = array_key_exists('limit', $parameters) &&
                  $parameters['limit'] !== null ? (int)$parameters['limit'] : 50;
        $offset = array_key_exists('offset', $parameters) &&
                  $parameters['offset'] !== null ? (int)$parameters['offset'] : 0;

        $agentIds = $this->agentService->getAgentIdsFromGroup($this->user->getAgent());

        list($properties, $count) = $this->propertyService->listAllProperties($agentIds, $limit, $offset);

        return [
            'properties' => Mapper::fromProperties($this->user->getSettings()->getLanguage(), ...$properties),
            'count'      => $count,
        ];
    }

    /**
     * @param array $parameters
     *
     * @return array $property
     * @throws NotAuthorizedException
     * @throws PropertyAlreadyExistsException
     * @throws ClientNotFoundException
     * @throws KindNotFoundException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     */
    private function createProperty(array $parameters)
    {
        // todo: covert to minimumAuthLevel(self::USER::COLLEAGUE);
        if ($this->user->getUserType()->getId() === self::USER_CLIENT ||
            $this->user->getUserType()->getId() === self::USER_API) {
            throw new NotAuthorizedException();
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
        $property->setAgent($this->user->getAgent());
        $property->setClient($this->clientService->getClient($parameters['client_id']));
        $property->setSubType($this->subTypeService->getSubType($parameters['sub_type_id']));

        $this->prepareParameters($property, $parameters);

        $this->propertyService->createProperty($property);

        $propertyId = (int)$property->getId();

        $this->logActivityService->createActivity(
            $this->user,
            $propertyId,
            'property',
            'create',
            null,
            $this->get('jms_serializer')->serialize($property, 'json')
        );

        $this->slackService->info(
            $this->user->getAgent()->getAgentGroup()->getName() .
            ' (' . $this->user->getFirstName() .
            ' ' . $this->user->getLastName() .
            ') added a new property: #' . $propertyId
        );

        // todo: also insert Details, Gallery, GeneralNotes
        // todo: create data folder

        return Mapper::fromProperty($this->user->getSettings()->getLanguage(), $property);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws ClientNotFoundException
     * @throws KindNotFoundException
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     */
    private function updateProperty(array $parameters)
    {
        $this->checkParameters([
            'id',
            'street',
            'house_number',
            'postcode',
            'city',
            'country',
            'lat',
            'lng',
        ], $parameters);

        $id       = (int)$parameters['id'];
        $property = $this->propertyService->getProperty($id);

        $this->isAuthorized($property->getAgent()->getId(), $this->user->getAgent()->getId());

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

        $this->prepareParameters($property, $parameters);

        $updatedProperty = $this->propertyService->updateProperty($property);

        $this->logActivityService->createActivity(
            $this->user,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );

        return Mapper::fromProperty($this->user->getSettings()->getLanguage(), $updatedProperty);

        // todo: also update Details, Gallery, GeneralNotes
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function archiveProperty(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $id       = (int)$parameters['id'];
        $property = $this->propertyService->getProperty($id);

        $this->isAuthorized($property->getAgent()->getId(), $this->user->getAgent()->getId());

        $this->propertyService->archiveProperty($property);

        $this->logActivityService->createActivity(
            $this->user,
            $id,
            'property',
            'archive',
            null,
            $this->get('jms_serializer')->serialize($property, 'json')
        );

        // todo: remove all photos apart from main from data folder and Gallery
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function deleteProperty(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        if ($this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        $this->propertyService->deleteProperty((int)$parameters['id']);

        // todo: delete info from not cascading tables too, including logBundle
        // todo: remove all photos from data folder and Gallery
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     * @throws TermsNotFoundException
     */
    private function setPropertySold(array $parameters)
    {
        $this->checkParameters([
            'id',
            'soldPrice',
        ], $parameters);

        $id        = (int)$parameters['id'];
        $soldPrice = (int)$parameters['soldPrice'];
        $property  = $this->propertyService->getProperty($id);

        $this->isAuthorized($property->getAgent()->getId(), $this->user->getAgent()->getId());

        $term            = $this->termsService->getTerm(9);
        $updatedProperty = $this->propertyService->setPropertySold($id, $soldPrice, $term);

        $this->logActivityService->createActivity(
            $this->user,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function toggleOnline(array $parameters)
    {
        $this->checkParameters([
            'id',
            'online',
        ], $parameters);

        $id       = (int)$parameters['id'];
        $online   = (bool)$parameters['online'];
        $property = $this->propertyService->getProperty($id);

        $this->isAuthorized($property->getAgent()->getId(), $this->user->getAgent()->getId());

        $updatedProperty = $this->propertyService->toggleOnline($id, $online);

        $this->logActivityService->createActivity(
            $this->user,
            $id,
            'property',
            'update',
            $this->get('jms_serializer')->serialize($property, 'json'),
            $this->get('jms_serializer')->serialize($updatedProperty, 'json')
        );
    }
}
