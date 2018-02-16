<?php
declare(strict_types = 1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Type;
use PropertyBundle\Exceptions\SubTypeNotFoundException;

/**
 * SubType Repository
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
     * @param Type $type
     *
     * @return SubType[]
     */
    public function listAllForType(Type $type): array
    {
        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('s')
            ->from('PropertyBundle:SubType', 's');

        if (!empty($type)) {
            $qb->where("s.type = :type");
            $qb->setParameter('type', $type);
        }

        $qb->orderBy('s.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
