<?php
declare(strict_types = 1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyBundle\Entity\Type;
use PropertyBundle\Exceptions\TypeNotFoundException;

/**
 * Type Repository
 */
class TypeRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Type
     * @throws TypeNotFoundException
     */
    public function findById(int $id): Type
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new TypeNotFoundException($id);
        }

        /** @var Type $result */
        return $result;
    }

    /**
     * @return Type[]
     */
    public function listAll(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('t')
                   ->from('PropertyBundle:Type', 't');

        $qb->orderBy('t.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        /** @var Type[] $results */
        return $results;
    }
}
