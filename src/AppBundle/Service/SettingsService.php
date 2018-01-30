<?php
declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Settings;
use AppBundle\Exceptions\SettingsNotFoundException;
use AppBundle\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Settings Service
 */
class SettingsService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SettingsRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Settings::class);
    }

    /**
     * @return Settings
     * @throws SettingsNotFoundException
     */
    public function getSettings(): Settings
    {
        return $this->repository->findById(1);
    }

    /**
     * @param Settings $settings
     *
     * @return Settings
     */
    public function updateSettings(Settings $settings): Settings
    {
        $this->entityManager->flush();

        return $settings;
    }
}
