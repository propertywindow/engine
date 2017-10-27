<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Entity\UserSettings;
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
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param User $user
     *
     * @return UserSettings $user
     */
    public function getSettings(User $user)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:UserSettings');
        $user       = $repository->findByUser($user);

        return $user;
    }

    /**
     * @param UserSettings $userSettings
     *
     * @return UserSettings
     */
    public function updateSettings(UserSettings $userSettings)
    {
        $this->entityManager->flush();

        return $userSettings;
    }
}
