<?php declare(strict_types=1);

namespace AuthenticationBundle\Repository;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Entity\UserSettings;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * UserSettingsRepository
 *
 */
class UserSettingsRepository extends EntityRepository
{
    /**
     * @param int $userId
     *
     * @return UserSettings
     *
     * @throws UserSettingsNotFoundException
     */
    public function findByUserId(int $userId): UserSettings
    {
        $result = $this->find($userId);

        if ($result === null) {
            throw new UserSettingsNotFoundException($userId);
        }

        /** @var UserSettings $result */
        return $result;
    }

    /**
     * @param User $user
     *
     * @return UserSettings
     *
     * @throws UserSettingsNotFoundException
     */
    public function findByUser(User $user): UserSettings
    {
        $result = $this->find($user);

        if ($result === null) {
            throw new UserSettingsNotFoundException($user->getId());
        }

        /** @var UserSettings $result */
        return $result;
    }
}
