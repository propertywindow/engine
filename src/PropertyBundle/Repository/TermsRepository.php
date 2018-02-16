<?php
declare(strict_types = 1);

namespace PropertyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyBundle\Entity\Terms;
use PropertyBundle\Exceptions\TermsNotFoundException;

/**
 * Terms Repository
 */
class TermsRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Terms
     * @throws TermsNotFoundException
     */
    public function findById(int $id): Terms
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new TermsNotFoundException($id);
        }

        /** @var Terms $result */
        return $result;
    }

    /**
     * @return Terms[]
     */
    public function listAll(): array
    {
        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('t')
            ->from('PropertyBundle:Terms', 't');

        $qb->orderBy('t.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
