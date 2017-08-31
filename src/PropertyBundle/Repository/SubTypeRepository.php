<?php declare(strict_types=1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Exceptions\SubTypeNotFoundException;

/**
 * SubTypeRepository
 *
 */
class SubTypeRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return SubType
     * @throws SubTypeNotFoundException
     */
    public function findById(int $id): SubType
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new SubTypeNotFoundException($id);
        }

        /** @var SubType $result */
        return $result;
    }

    /**
     * @param int|null $typeId
     *
     * @return SubType[]
     */
    public function listAll(?int $typeId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('s')
                   ->from('PropertyBundle:SubType', 's');

        if (!empty($typeId)) {
            $qb->where("s.typeId = :typeId");
            $qb->setParameter('typeId', $typeId);
        }

        $qb->orderBy('s.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
