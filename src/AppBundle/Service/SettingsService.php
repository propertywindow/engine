<?php
declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Settings;
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
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @return Settings $settings
     * @throws \AppBundle\Exceptions\SettingsNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getSettings()
    {
        $repository = $this->entityManager->getRepository(Settings::class);
        $settings   = $repository->findById(1);

        return $settings;
    }

    /**
     * @param Settings $settings
     *
     * @return Settings
     */
    public function updateSettings(Settings $settings)
    {
        $this->entityManager->flush();

        return $settings;
    }
}
