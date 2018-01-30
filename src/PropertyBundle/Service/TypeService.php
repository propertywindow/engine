<?php
declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Type;
use PropertyBundle\Exceptions\TypeDeleteException;
use PropertyBundle\Exceptions\TypeNotFoundException;
use PropertyBundle\Repository\SubTypeRepository;
use PropertyBundle\Repository\TypeRepository;

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
     * @var TypeRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Type::class);
    }

    /**
     * @param int $id
     *
     * @return Type
     * @throws TypeNotFoundException
     */
    public function getType(int $id): Type
    {
        return $this->repository->findById($id);
    }

    /**
     * @return Type[]
     */
    public function getTypes(): array
    {
        return $this->repository->listAll();
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
        $type           = $this->repository->findById($id);

        /** @var SubTypeRepository $subTypeRepository */
        $subTypeRepository = $this->entityManager->getRepository(SubType::class);
        $subTypes          = $subTypeRepository->listAll($type);

        if (!empty($subTypes)) {
            throw new TypeDeleteException($id);
        }

        $this->entityManager->remove($type);
        $this->entityManager->flush();
    }
}
