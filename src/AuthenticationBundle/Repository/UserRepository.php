<?php declare(strict_types=1);

namespace AuthenticationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\UserNotFoundException;

/**
 * UserRepository
 *
 */
class UserRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): User
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new UserNotFoundException($id);
        }

        /** @var User $result */
        return $result;
    }

    /**
     * @param int $id
     *
     * @return int $userType
     * @throws UserNotFoundException
     */
    public function getUserType(int $id): int
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new UserNotFoundException($id);
        }

        $userType = (int)$result->getTypeId();

        return $userType;
    }
}
