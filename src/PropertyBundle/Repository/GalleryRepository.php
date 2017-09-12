<?php declare(strict_types=1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyBundle\Entity\Gallery;
use PropertyBundle\Exceptions\GalleryNotFoundException;

/**
 * GalleryRepository
 *
 */
class GalleryRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Gallery
     *
     * @throws GalleryNotFoundException
     */
    public function findById(int $id): Gallery
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new GalleryNotFoundException($id);
        }

        /** @var Gallery $result */
        return $result;
    }
}
