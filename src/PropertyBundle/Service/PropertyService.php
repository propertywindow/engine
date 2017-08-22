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
     * @param Property $property
     *
     * @return Property
     *
     * @throws \Doctrine\ORM\OptimisticLockException
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

        $this->entityManager->remove($property);
        $this->entityManager->flush();
    }
}
