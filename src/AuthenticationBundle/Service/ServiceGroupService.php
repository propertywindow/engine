<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\ServiceGroup;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
use AuthenticationBundle\Repository\ServiceGroupRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ServiceGroup Service
 */
class ServiceGroupService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ServiceGroupRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(ServiceGroup::class);
    }

    /**
     * @param int $id
     *
     * @return ServiceGroup
     * @throws ServiceGroupNotFoundException
     */
    public function getServiceGroup(int $id): ServiceGroup
    {
        return $this->repository->findById($id);
    }

    /**
     * @return array|ServiceGroup[]
     */
    public function getServiceGroups(): array
    {
        return $this->repository->listAll();
    }
}
