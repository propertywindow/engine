<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Type;
use PropertyBundle\Exceptions\SubTypeDeleteException;

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
     */
    public function getSubType(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:SubType');
        $subType    = $repository->findById($id);

        return $subType;
    }

    /**
     * @param Type $type
     *
     * @return SubType[]
     */
    public function getSubTypes(Type $type)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:SubType');

        return $repository->listAll($type);
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
     * @throws SubTypeDeleteException
     */
    public function deleteSubType(int $id)
    {
        $subTypeRepository = $this->entityManager->getRepository('PropertyBundle:SubType');
        $subType           = $subTypeRepository->findById($id);

        $propertyRepository = $this->entityManager->getRepository('PropertyBundle:Property');
        $subTypes           = $propertyRepository->findPropertiesWithSubType($subType->getId());

        if (!empty($subTypes)) {
            throw new SubTypeDeleteException($id);
        }

        $this->entityManager->remove($subType);
        $this->entityManager->flush();
    }
}
