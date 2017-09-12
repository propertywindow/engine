<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Entity\ServiceGroup;
use AuthenticationBundle\Entity\ServiceGroupMap;
use AuthenticationBundle\Entity\ServiceMap;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\ServiceMapAlreadyExistsException;
use AuthenticationBundle\Exceptions\ServiceMapNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AuthenticationBundle\Service
 */
class ServiceMapService
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
     * @param User $user
     *
     * @return ServiceMap $serviceMap
     *
     * @throws ServiceMapNotFoundException
     */
    public function getServiceMap(User $user)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:ServiceMap');
        $serviceMap = $repository->findBy(
            [
                'user' => $user,
            ]
        );

        /** @var ServiceMap $serviceMap */
        if ($serviceMap === null) {
            throw new ServiceMapNotFoundException($serviceMap->setService()->getId());
        }

        return $serviceMap;
    }

    /**
     * @param User $user
     *
     * @return ServiceGroupMap $serviceGroupMap
     *
     * @throws ServiceMapNotFoundException
     */
    public function getServiceGroupMap(User $user)
    {
        $repository      = $this->entityManager->getRepository('AuthenticationBundle:ServiceGroupMap');
        $serviceGroupMap = $repository->findBy(
            [
                'user' => $user,
            ]
        );

        /** @var ServiceGroupMap $serviceGroupMap */
        if ($serviceGroupMap === null) {
            throw new ServiceMapNotFoundException($serviceGroupMap->getServiceGroup()->getId());
        }

        return $serviceGroupMap;
    }


    /**
     * @param User $user
     *
     * @return ServiceGroup[] $serviceGroups
     */
    public function getAuthorizedServiceGroups(User $user)
    {
        $repository       = $this->entityManager->getRepository('AuthenticationBundle:ServiceGroupMap');
        $serviceGroupMaps = $repository->listAll($user);
        $serviceGroups    = [];

        foreach ($serviceGroupMaps as $serviceGroupMap) {
            $serviceGroups[] = $serviceGroupMap->getServiceGroup();
        }

        return $serviceGroups;
    }


    /**
     * @param User    $user
     * @param Service $service
     *
     * @return ServiceMap $serviceMap
     *
     * @throws ServiceMapAlreadyExistsException
     */
    public function addToServiceMap(User $user, Service $service)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:ServiceMap');
        $serviceMap = $repository->findOneBy(
            [
                'user'    => $user,
                'service' => $service,
            ]
        );

        /** @var ServiceMap $serviceMap */
        if ($serviceMap !== null) {
            throw new ServiceMapAlreadyExistsException($service->getId());
        }

        $serviceMap = new ServiceMap();

        $serviceMap->setUser($user);
        $serviceMap->setService($service);

        $this->entityManager->persist($serviceMap);
        $this->entityManager->flush();

        return $serviceMap;
    }

    /**
     * @param User         $user
     * @param ServiceGroup $serviceGroup
     *
     * @return ServiceGroupMap $serviceGroupMap
     *
     * @throws ServiceMapAlreadyExistsException
     */
    public function addToServiceGroupMap(User $user, ServiceGroup $serviceGroup)
    {
        $repository      = $this->entityManager->getRepository('AuthenticationBundle:ServiceGroupMap');
        $serviceGroupMap = $repository->findOneBy(
            [
                'user'        => $user,
                'serviceGroup' => $serviceGroup,
            ]
        );

        /** @var ServiceGroupMap $serviceGroupMap */
        if ($serviceGroupMap !== null) {
            throw new ServiceMapAlreadyExistsException($serviceGroup->getId());
        }

        $serviceGroupMap = new ServiceGroupMap();

        $serviceGroupMap->setUser($user);
        $serviceGroupMap->setServiceGroup($serviceGroup);

        $this->entityManager->persist($serviceGroupMap);
        $this->entityManager->flush();

        return $serviceGroupMap;
    }

    /**
     * @param User    $user
     * @param Service $service
     *
     * @throws ServiceMapNotFoundException
     */
    public function removeFromServiceMap(User $user, Service $service)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:ServiceMap');
        $serviceMap = $repository->findOneBy(
            [
                'user'    => $user,
                'service' => $service,
            ]
        );

        /** @var ServiceMap $serviceMap */
        if ($serviceMap === null) {
            throw new ServiceMapNotFoundException($service->getId());
        }

        $this->entityManager->remove($serviceMap);
        $this->entityManager->flush();
    }

    /**
     * @param User         $user
     * @param ServiceGroup $serviceGroup
     *
     * @throws ServiceMapNotFoundException
     */
    public function removeFromServiceGroupMap(User $user, ServiceGroup $serviceGroup)
    {
        $repository      = $this->entityManager->getRepository('AuthenticationBundle:ServiceGroupMap');
        $serviceGroupMap = $repository->findOneBy(
            [
                'user'        => $user,
                'serviceGroup' => $serviceGroup,
            ]
        );

        /** @var ServiceGroupMap $serviceGroupMap */
        if ($serviceGroupMap === null) {
            throw new ServiceMapNotFoundException($serviceGroup->getId());
        }

        $this->entityManager->remove($serviceGroupMap);
        $this->entityManager->flush();
    }
}
