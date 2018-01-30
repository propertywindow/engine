<?php
declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Type;
use PropertyBundle\Exceptions\TypeDeleteException;
use PropertyBundle\Exceptions\TypeNotFoundException;

/**
 * Type Service
 */
class TypeService
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
     * @return Type $type
     * @throws TypeNotFoundException
     */
    public function getType(int $id)
    {
        $repository = $this->entityManager->getRepository(Type::class);
        $type       = $repository->findById($id);

        return $type;
    }

    /**
     * @return Type[]
     */
    public function getTypes()
    {
        $repository = $this->entityManager->getRepository(Type::class);

        return $repository->listAll();
    }

    /**
     * @param Type $type
     *
     * @return Type
     */
    public function createType(Type $type)
    {
        $this->entityManager->persist($type);
        $this->entityManager->flush();

        return $type;
    }

    /**
     * @param Type $type
     *
     * @return Type
     */
    public function updateType(Type $type)
    {
        $this->entityManager->flush();

        return $type;
    }

    /**
     * @param int $id
     *
     * @throws TypeDeleteException
     * @throws TypeNotFoundException
     */
    public function deleteType(int $id)
    {
        $typeRepository = $this->entityManager->getRepository(Type::class);
        $type           = $typeRepository->findById($id);

        $subTypeRepository = $this->entityManager->getRepository(SubType::class);
        $subTypes          = $subTypeRepository->listAll($type);

        if (!empty($subTypes)) {
            throw new TypeDeleteException($id);
        }

        $this->entityManager->remove($type);
        $this->entityManager->flush();
    }
}
