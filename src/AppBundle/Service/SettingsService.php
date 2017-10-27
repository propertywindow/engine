<?php declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AppBundle\Service
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
     */
    public function getSettings()
    {
        $repository   = $this->entityManager->getRepository('AppBundle:Settings');
        $settings = $repository->findById(1);

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
