<?php declare(strict_types=1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyBundle\Entity\Type;

/**
 * TypeRepository
 *
 */
class TypeRepository extends EntityRepository
{
    /**
     * @return Type[]
     * @throws \Doctrine\ORM\RuntimeException
     */
    public function listAll(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('n')
                   ->from('PropertyBundle:Type', 'n');

        $qb->orderBy('n.id', 'DESC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
