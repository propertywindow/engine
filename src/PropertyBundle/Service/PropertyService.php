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
     * @param  int $userId
     *
     * @return array|Property[] $notifications
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\RuntimeException
     */
    public function getByUserId(int $userId): array
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');

        return $repository->findPropertiesForUser($userId);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array|Property First value Property[], second value the total count.
     * @throws \Doctrine\ORM\RuntimeException
     */
    public function listProperties(?int $limit, ?int $offset)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Property');

        return $repository->listAll($limit, $offset);
    }
}
