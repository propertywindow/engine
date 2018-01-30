<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\ServiceGroup;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use AuthenticationBundle\Repository\ServiceRepository;
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
     * @var ServiceRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Service::class);
    }

    /**
     * @param int $id
     *
     * @return Service
     * @throws ServiceNotFoundException
     */
    public function getService(int $id): Service
    {
        return $this->repository->findById($id);
    }

    /**
     * @param ServiceGroup $serviceGroup
     *
     * @return array|Service[]
     */
    public function getServices(ServiceGroup $serviceGroup): array
    {
        return $this->repository->listAll($serviceGroup);
    }
}
