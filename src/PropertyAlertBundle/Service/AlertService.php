<?php declare(strict_types=1);

namespace PropertyAlertBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyAlertBundle\Entity\Alert;
use PropertyAlertBundle\Exceptions\AlertNotFoundException;

/**
 * @package PropertyAlertBundle\Service
 */
class AlertService
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
     * @param int $id
     *
     * @return Alert $alert
     *
     * @throws AlertNotFoundException
     */
    public function getAlert(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyAlertBundle:Alert');
        $alert      = $repository->findById($id);

        return $alert;
    }

    /**
     * @param Alert $alert
     *
     * @return Alert
     */
    public function createAlert(Alert $alert)
    {
        $this->entityManager->persist($alert);
        $this->entityManager->flush();

        return $alert;
    }

    /**
     * @param Alert $alert
     *
     * @return Alert
     */
    public function updateAlert(Alert $alert)
    {
        $this->entityManager->flush();

        return $alert;
    }
}
