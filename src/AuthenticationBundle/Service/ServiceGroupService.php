<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\ServiceGroup;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AuthenticationBundle\Service
 */
class ServiceGroupService
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
     * @return ServiceGroup $serviceGroup
     */
    public function getServiceGroup(int $id)
    {
        $repository   = $this->entityManager->getRepository('AuthenticationBundle:ServiceGroup');
        $serviceGroup = $repository->findById($id);

        return $serviceGroup;
    }

    /**
     * @return array|ServiceGroup[]
     */
    public function getServiceGroups()
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:ServiceGroup');

        return $repository->listAll();
    }
}
