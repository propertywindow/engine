<?php declare(strict_types = 1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Exceptions\KindNotFoundException;

/**
 * KindRepository
 */
class KindRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Kind
     * @throws KindNotFoundException
     */
    public function findById(int $id): Kind
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new KindNotFoundException($id);
        }

        /** @var Kind $result */
        return $result;
    }
}
