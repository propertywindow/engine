<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Property;
use PropertyBundle\Exceptions\PropertyNotFoundException;

/**
 * @package PropertyBundle\Service
 */
class PropertyService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }


    /**
     * @param int $id
     *
     * @return Property $property
     *
     * @throws PropertyNotFoundException
     */
    public function getProperty(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');
        $property   = $repository->find($id);

        if ($property === null) {
            throw new PropertyNotFoundException($id);
        }

        return $property;
    }

    /**
     * @param  int $agentId
     *
     * @return array|Property[] $properties
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function listProperties(int $agentId): array
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');

        return $repository->listProperties($agentId);
    }

    /**
     * @param int[]    $agentIds
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array|Property First value Property[], second value the total count.
     */
    public function listAllProperties(array $agentIds, ?int $limit, ?int $offset)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');

        return $repository->listAllProperties($agentIds, $limit, $offset);
    }

    /**
     * @param array $parameters
     *
     * @return Property
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createProperty(array $parameters)
    {
        $property = new Property();

        $property->setKind($parameters['kind']);
        $property->setAgentId($parameters['agent_id']);
        $property->setClientId($parameters['client_id']);
        $property->setStreet(ucfirst($parameters['street']));
        $property->setHouseNumber($parameters['house_number']);
        $property->setPostcode($parameters['postcode']);
        $property->setCity(ucfirst($parameters['city']));
        $property->setCountry($parameters['country']);
        $property->setSubType($parameters['sub_type_id']);
        $property->setLat($parameters['lat']);
        $property->setLng($parameters['lng']);

        if (array_key_exists('terms', $parameters) && $parameters['terms'] !== null) {
            $property->setTerms((int)$parameters['terms']);
        }
        if (array_key_exists('online', $parameters) && $parameters['online'] !== null) {
            $property->setOnline((bool)$parameters['online']);
        }
        if (array_key_exists('price', $parameters) && $parameters['price'] !== null) {
            $property->setPrice((int)$parameters['price']);
        }
        if (array_key_exists('espc', $parameters) && $parameters['espc'] !== null) {
            $property->setEspc((bool)$parameters['espc']);
        }

        $this->entityManager->persist($property);
        $this->entityManager->flush();

        return $property;
    }

    /**
     * @param Property $property
     *
     * @return Property
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateProperty(Property $property)
    {
        $this->entityManager->flush();

        return $property;
    }

    /**
     * @param int $id
     *
     * @throws PropertyNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function archiveProperty(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');
        $property   = $repository->find($id);

        $property->setArchived(true);

        $this->entityManager->flush();
    }

    /**
     * @param int $id
     *
     * @throws PropertyNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteProperty(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');
        $property   = $repository->find($id);

        if ($property === null) {
            throw new PropertyNotFoundException($id);
        }

        $this->entityManager->remove($property);
        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @param int $soldPrice
     *
     * @return Property
     * @throws PropertyNotFoundException
     */
    public function setPropertySold(int $id, int $soldPrice)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');
        $property   = $repository->find($id);

        if ($property === null) {
            throw new PropertyNotFoundException($id);
        }

        $property->setOnline($soldPrice);
        $property->setTerms(9);

        $this->entityManager->flush();

        return $property;
    }

    /**
     * @param int  $id
     * @param bool $online
     *
     * @return Property
     * @throws PropertyNotFoundException
     */
    public function toggleOnline(int $id, bool $online)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');
        $property   = $repository->find($id);

        if ($property === null) {
            throw new PropertyNotFoundException($id);
        }

        $property->setOnline($online);

        $this->entityManager->flush();

        return $property;
    }
}
