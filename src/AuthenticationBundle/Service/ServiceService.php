<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;

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
     *
     * @throws ServiceNotFoundException
     */
    public function getService(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:Service');
        $service    = $repository->find($id);

        /** @var Service $service */
        if ($service === null) {
            throw new ServiceNotFoundException($id);
        }

        return $service;
    }
}
