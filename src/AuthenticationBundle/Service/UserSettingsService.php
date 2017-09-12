<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

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
     * @param int $userId
     *
     * @return UserSettings $user
     */
    public function getSettings(int $userId)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:UserSettings');
        $user       = $repository->findByUserId($userId);

        return $user;
    }
}
