<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Exceptions\SubTypeDeleteException;
use PropertyBundle\Exceptions\SubTypeNotFoundException;

/**
 * @package PropertyBundle\Service
 */
class SubTypeService
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
     * @return SubType $subType
     *
     * @throws SubTypeNotFoundException
     */
    public function getSubType(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:SubType');
        $subType    = $repository->find($id);

        /** @var SubType $subType */
        if ($subType === null) {
            throw new SubTypeNotFoundException($id);
        }

        return $subType;
    }

    /**
     * @param int|null $typeId
     *
     * @return SubType[]
     */
    public function getSubTypes(?int $typeId)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:SubType');

        return $repository->listAll($typeId);
    }

    /**
     * @param SubType $subType
     *
     * @return SubType
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createSubType(SubType $subType)
    {
        $this->entityManager->persist($subType);
        $this->entityManager->flush();

        return $subType;
    }

    /**
     * @param SubType $subType
     *
     * @return SubType
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateSubType(SubType $subType)
    {
        $this->entityManager->flush();

        return $subType;
    }

    /**
     * @param int $id
     *
     * @throws SubTypeNotFoundException
     * @throws SubTypeDeleteException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteSubType(int $id)
    {
        $subTypeRepository  = $this->entityManager->getRepository('PropertyBundle:SubType');
        $type               = $subTypeRepository->findById($id);
        $propertyRepository = $this->entityManager->getRepository('PropertyBundle:Property');
        $subTypes           = $propertyRepository->findPropertiesWithSubType($type->getId());

        if (!empty($subTypes)) {
            throw new SubTypeDeleteException($id);
        }

        $this->entityManager->remove($type);
        $this->entityManager->flush();
    }
}
