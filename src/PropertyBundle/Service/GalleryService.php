<?php
declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Gallery;
use PropertyBundle\Exceptions\GalleryNotFoundException;

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
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Gallery $gallery
     * @throws GalleryNotFoundException
     */
    public function getPhoto(int $id): Gallery
    {
        $repository = $this->entityManager->getRepository(Gallery::class);
        $gallery    = $repository->findById($id);

        return $gallery;
    }

    /**
     * @return Gallery[]
     */
    public function getGallery()
    {
        $repository = $this->entityManager->getRepository(Gallery::class);

        return $repository->findAll();
    }
}
