<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Gallery;

/**
 * @package PropertyBundle\Service
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
     */
    public function getPhoto(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Gallery');
        $gallery    = $repository->findById($id);

        return $gallery;
    }

    /**
     * @return Gallery[]
     */
    public function getGallery()
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Gallery');

        return $repository->findAll();
    }
}
