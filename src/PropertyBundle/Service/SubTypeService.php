<?php
declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Property;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Type;
use PropertyBundle\Exceptions\SubTypeDeleteException;
use PropertyBundle\Exceptions\SubTypeNotFoundException;
use PropertyBundle\Repository\PropertyRepository;
use PropertyBundle\Repository\SubTypeRepository;

/**
 * SubType Service
 */
class SubTypeService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SubTypeRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(SubType::class);
    }

    /**
     * @param int $id
     *
     * @return SubType
     * @throws SubTypeNotFoundException
     */
    public function getSubType(int $id): SubType
    {
        return $this->repository->findById($id);
    }

    /**
     * @return SubType[]
     */
    public function getSubTypes(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Type $type
     *
     * @return SubType[]
     */
    public function getSubTypesForType(Type $type): array
    {
        return $this->repository->listAllForType($type);
    }

    /**
     * @param SubType $subType
     *
     * @return SubType
     */
    public function createSubType(SubType $subType): SubType
    {
        $this->entityManager->persist($subType);
        $this->entityManager->flush();

        return $subType;
    }

    /**
     * @param SubType $subType
     *
     * @return SubType
     */
    public function updateSubType(SubType $subType): SubType
    {
        $this->entityManager->flush();

        return $subType;
    }

    /**
     * @param int $id
     *
     * @throws SubTypeDeleteException
     * @throws SubTypeNotFoundException
     */
    public function deleteSubType(int $id)
    {
        $subType = $this->repository->findById($id);

        /** @var PropertyRepository $propertyRepository */
        $propertyRepository = $this->entityManager->getRepository(Property::class);
        $subTypes           = $propertyRepository->findPropertiesWithSubType($subType->getId());

        if (!empty($subTypes)) {
            throw new SubTypeDeleteException($id);
        }

        $this->entityManager->remove($subType);
        $this->entityManager->flush();
    }
}
