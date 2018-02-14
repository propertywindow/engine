<?php
declare(strict_types = 1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Gallery;
use PropertyBundle\Exceptions\GalleryNotFoundException;
use PropertyBundle\Repository\GalleryRepository;

/**
 * Gallery Service
 */
class GalleryService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var GalleryRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Gallery::class);
    }

    /**
     * @param int $id
     *
     * @return Gallery
     * @throws GalleryNotFoundException
     */
    public function getPhoto(int $id): Gallery
    {
        return $this->repository->findById($id);
    }

    /**
     * @return Gallery[]
     */
    public function getGallery(): array
    {
        return $this->repository->findAll();
    }
}
