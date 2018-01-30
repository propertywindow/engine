<?php
declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Property;
use PropertyBundle\Exceptions\PropertyNotFoundException;
use PropertyBundle\Repository\PropertyRepository;

/**
 * Property Service
 */
class PropertyService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Property::class);
    }

    /**
     * @param int $id
     *
     * @return Property $property
     * @throws PropertyNotFoundException
     */
    public function getProperty(int $id)
    {
        $property = $this->repository->findById($id);

        return $property;
    }

    /**
     * @param array $parameters
     *
     * @return bool
     */
    public function checkExistence(array $parameters)
    {
        $property = $this->repository->findOneBy(
            [
                'client'      => (int)$parameters['client_id'],
                'postcode'    => $parameters['postcode'],
                'houseNumber' => $parameters['house_number'],
                'archived'    => false,
            ]
        );

        if ($property === null) {
            return false;
        }

        return true;
    }

    /**
     * @param  int $agentId
     *
     * @return array|Property[] $properties
     */
    public function listProperties(int $agentId): array
    {
        return $this->repository->listProperties($agentId);
    }

    /**
     * @param int[] $agentIds
     * @param int   $limit
     * @param int   $offset
     *
     * @return array|Property First value Property[], second value the total count.
     */
    public function listAllProperties(array $agentIds, int $limit, int $offset)
    {
        return $this->repository->listAllProperties($agentIds, $limit, $offset);
    }

    /**
     * @param Property $property
     *
     * @return Property
     */
    public function createProperty(Property $property)
    {
        $this->entityManager->persist($property);
        $this->entityManager->flush();

        return $property;
    }

    /**
     * @param Property $property
     *
     * @return Property
     */
    public function updateProperty(Property $property)
    {
        $this->entityManager->flush();

        return $property;
    }

    /**
     * @param Property $property
     */
    public function archiveProperty(Property $property)
    {
        $property->setArchived(true);

        $this->entityManager->flush();
    }

    /**
     * @param int $id
     *
     * @throws PropertyNotFoundException
     */
    public function deleteProperty(int $id)
    {
        $property = $this->repository->find($id);

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
        $property = $this->repository->find($id);

        /** @var Property $property */
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
        $property = $this->repository->find($id);

        /** @var Property $property */
        if ($property === null) {
            throw new PropertyNotFoundException($id);
        }

        $property->setOnline($online);

        $this->entityManager->flush();

        return $property;
    }
}
