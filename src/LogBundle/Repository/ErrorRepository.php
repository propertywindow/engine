<?php declare(strict_types=1);

namespace LogBundle\Repository;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use LogBundle\Entity\Error;
use LogBundle\Exceptions\ErrorNotFoundException;

/**
 * ErrorRepository
 */
class ErrorRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Error
     * @throws ErrorNotFoundException
     */
    public function findById(int $id): Error
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ErrorNotFoundException($id);
        }

        /** @var Error $result */
        return $result;
    }

    /**
     * @param User $user
     *
     * @return Error[]
     */
    public function findByUser(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('a')
                   ->from('LogBundle:Error', 'a')
                   ->where("a.user = :user")
                   ->setParameter('user', $user)
                   ->orderBy('a.created', 'DESC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
