<?php
declare(strict_types = 1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\JsonController;
use ClientBundle\Exceptions\ClientNotFoundException;
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
class PropertyController extends JsonController
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
            $method          = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($method));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param string $method
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     */
    public function invoke(string $method)
    {
        if (is_callable([$this, $method])) {
            return $this->$method();
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }


    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function getProperty(): array
    {
        $this->checkParameters(['id']);

        $property = $this->propertyService->getProperty((int)$this->parameters['id']);

        $this->isAuthorized($property->getAgent()->getId(), $this->user->getAgent()->getId());

        $this->logTraffic($property);

        return Mapper::fromProperty($this->user->getSettings()->getLanguage(), $property);
    }

    /**
     * @return array
     */
    private function getProperties(): array
    {
        return Mapper::fromProperties($this->user->getSettings()->getLanguage(), ...
            $this->propertyService->listProperties($this->user->getAgent()));
    }

    /**
     * @return array
     */
    private function getAllProperties(): array
    {
        $limit  = array_key_exists('limit', $this->parameters) &&
                  $this->parameters['limit'] !== null ? (int)$this->parameters['limit'] : 50;
        $offset = array_key_exists('offset', $this->parameters) &&
                  $this->parameters['offset'] !== null ? (int)$this->parameters['offset'] : 0;

        $agentIds = $this->agentService->getAgentIdsFromGroup($this->user->getAgent());

        list($properties, $count) = $this->propertyService->listAllProperties($agentIds, $limit, $offset);

        return [
            'properties' => Mapper::fromProperties($this->user->getSettings()->getLanguage(), ...$properties),
            'count'      => $count,
        ];
    }

    /**
     * @return array $property
     * @throws KindNotFoundException
     * @throws NotAuthorizedException
     * @throws PropertyAlreadyExistsException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     * @throws ClientNotFoundException
     */
    private function createProperty(): array
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

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
        ]);

        if ($this->propertyService->checkExistence($this->parameters)) {
            throw new PropertyAlreadyExistsException($this->parameters['client_id']);
        }

        $property = new Property();

        $property->setKind($this->kindService->getKind($this->parameters['kind_id']));
        $property->setTerms($this->termsService->getTerm($this->parameters['terms_id']));
        $property->setAgent($this->user->getAgent());
        $property->setClient($this->clientService->getClient($this->parameters['client_id']));
        $property->setSubType($this->subTypeService->getSubType($this->parameters['sub_type_id']));

        $this->prepareParameters($property);

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
     * @return array
     * @throws ClientNotFoundException
     * @throws KindNotFoundException
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     */
    private function updateProperty(): array
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
        ]);

        $id       = (int)$this->parameters['id'];
        $property = $this->propertyService->getProperty($id);

        $this->isAuthorized($property->getAgent()->getId(), $this->user->getAgent()->getId());

        if (array_key_exists('client_id', $this->parameters) && $this->parameters['client_id'] !== null) {
            $client = $this->clientService->getClient($this->parameters['client_id']);
            $property->setClient($client);
        }

        if (array_key_exists('kind_id', $this->parameters) && $this->parameters['kind_id'] !== null) {
            $kind = $this->kindService->getKind($this->parameters['kind_id']);
            $property->setKind($kind);
        }

        if (array_key_exists('sub_type_id', $this->parameters) && $this->parameters['sub_type_id'] !== null) {
            $subType = $this->subTypeService->getSubType($this->parameters['sub_type_id']);
            $property->setSubType($subType);
        }

        if (array_key_exists('terms_id', $this->parameters) && $this->parameters['terms_id'] !== null) {
            $terms = $this->termsService->getTerm($this->parameters['terms_id']);
            $property->setTerms($terms);
        }

        $this->prepareParameters($property);

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
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function archiveProperty()
    {
        $this->checkParameters(['id']);

        $id       = (int)$this->parameters['id'];
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
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function deleteProperty()
    {
        $this->checkParameters(['id']);

        $this->hasAccessLevel(self::USER_AGENT);

        $this->propertyService->deleteProperty((int)$this->parameters['id']);

        // todo: delete info from not cascading tables too, including logBundle
        // todo: remove all photos from data folder and Gallery
    }

    /**
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     * @throws TermsNotFoundException
     */
    private function setPropertySold()
    {
        $this->checkParameters([
            'id',
            'soldPrice',
        ]);

        $id        = (int)$this->parameters['id'];
        $soldPrice = (int)$this->parameters['soldPrice'];
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
     * @throws NotAuthorizedException
     * @throws PropertyNotFoundException
     */
    private function toggleOnline()
    {
        $this->checkParameters([
            'id',
            'online',
        ]);

        $id       = (int)$this->parameters['id'];
        $online   = (bool)$this->parameters['online'];
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

    /**
     * @param Property $property
     */
    private function logTraffic(Property $property)
    {
        if ($this->user->getUserType()->getId() === self::USER_API) {
            $this->checkParameters([
                'ip',
                'browser',
                'location',
            ]);

            $this->logTrafficService->createTraffic(
                $property,
                (string)$this->parameters['id'],
                (string)$this->parameters['browser'],
                (string)$this->parameters['location'],
                (string)$this->parameters['referrer']
            );
        }
    }
}
