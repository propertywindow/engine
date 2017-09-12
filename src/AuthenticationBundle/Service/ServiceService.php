<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\ServiceGroup;
use Doctrine\ORM\EntityManagerInterface;
use AuthenticationBundle\Entity\Service;

/**
 * @package AuthenticationBundle\Service
 */
class ServiceService
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
     * @return Service $service
     */
    public function getService(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Service');
        $service    = $repository->findById($id);

        return $service;
    }

    /**
     * @param ServiceGroup $serviceGroup
     *
     * @return array|Service[]
     */
    public function getServices(ServiceGroup $serviceGroup)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Service');

        return $repository->listAll($serviceGroup);
    }
}
