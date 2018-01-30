<?php
declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Entity\UserSettings;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use AuthenticationBundle\Repository\UserSettingsRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AuthenticationBundle\Service
 */
class UserSettingsService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserSettingsRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(UserSettings::class);
    }

    /**
     * @param User $user
     *
     * @return UserSettings
     * @throws UserSettingsNotFoundException
     */
    public function getSettings(User $user): UserSettings
    {
        return $this->repository->findByUser($user);
    }

    /**
     * @param UserSettings $userSettings
     *
     * @return UserSettings
     */
    public function updateSettings(UserSettings $userSettings): UserSettings
    {
        $this->entityManager->flush();

        return $userSettings;
    }
}
