<?php
declare(strict_types = 1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Exceptions\KindNotFoundException;
use PropertyBundle\Repository\KindRepository;

/**
 * @package PropertyBundle\Service
 */
class KindService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var KindRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Kind::class);
    }

    /**
     * @param int $id
     *
     * @return Kind
     * @throws KindNotFoundException
     */
    public function getKind(int $id): Kind
    {
        return $this->repository->findById($id);
    }

    /**
     * @return Kind[]
     */
    public function getKinds(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Kind $kind
     *
     * @return Kind
     */
    public function createKind(Kind $kind): Kind
    {
        $this->entityManager->persist($kind);
        $this->entityManager->flush();

        return $kind;
    }

    /**
     * @param Kind $kind
     *
     * @return Kind
     */
    public function updateKind(Kind $kind): Kind
    {
        $this->entityManager->flush();

        return $kind;
    }

    /**
     * @param int $id
     *
     * @throws KindNotFoundException
     */
    public function deleteKind(int $id)
    {
        $kind = $this->repository->findById($id);

        $this->entityManager->remove($kind);
        $this->entityManager->flush();
    }
}
