<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AuthenticationBundle\Service
 */
class ServiceTemplatesService
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
}
