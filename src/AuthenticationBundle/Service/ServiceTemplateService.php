<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Entity\ServiceGroup;
use AuthenticationBundle\Entity\ServiceGroupTemplate;
use AuthenticationBundle\Entity\ServiceTemplate;
use AuthenticationBundle\Entity\UserType;
use AuthenticationBundle\Exceptions\TemplateAlreadyHasServiceException;
use AuthenticationBundle\Exceptions\TemplateNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package AuthenticationBundle\Service
 */
class ServiceTemplateService
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
     * @param UserType $userType
     *
     * @return ServiceTemplate $serviceTemplate
     *
     * @throws TemplateNotFoundException
     */
    public function getServiceTemplate(UserType $userType)
    {
        $repository      = $this->entityManager->getRepository('AuthenticationBundle:ServiceTemplate');
        $serviceTemplate = $repository->findBy(
            [
                'userType' => $userType,
            ]
        );

        /** @var ServiceTemplate $serviceTemplate */
        if ($serviceTemplate === null) {
            throw new TemplateNotFoundException($userType->getId());
        }

        return $serviceTemplate;
    }

    /**
     * @param UserType $userType
     * @param Service  $service
     *
     * @return ServiceTemplate $serviceTemplate
     *
     * @throws TemplateAlreadyHasServiceException
     */
    public function addToServiceTemplate(UserType $userType, Service $service)
    {
        $repository      = $this->entityManager->getRepository('AuthenticationBundle:ServiceTemplate');
        $serviceTemplate = $repository->findOneBy(
            [
                'userType' => $userType,
                'service'  => $service,
            ]
        );

        /** @var ServiceTemplate $serviceTemplate */
        if ($serviceTemplate !== null) {
            throw new TemplateAlreadyHasServiceException($userType->getEn(), $service->getId());
        }

        $serviceTemplate = new ServiceTemplate();

        $serviceTemplate->setUserType($userType);
        $serviceTemplate->setService($service);

        $this->entityManager->persist($serviceTemplate);
        $this->entityManager->flush();

        return $serviceTemplate;
    }

    /**
     * @param UserType     $userType
     * @param ServiceGroup $serviceGroup
     *
     * @return ServiceGroupTemplate $serviceGroupTemplate
     *
     * @throws TemplateAlreadyHasServiceException
     */
    public function addToServiceGroupTemplate(UserType $userType, ServiceGroup $serviceGroup)
    {
        $repository           = $this->entityManager->getRepository('AuthenticationBundle:ServiceGroupTemplate');
        $serviceGroupTemplate = $repository->findOneBy(
            [
                'userType'     => $userType,
                'serviceGroup' => $serviceGroup,
            ]
        );

        /** @var ServiceGroupTemplate $serviceGroupTemplate */
        if ($serviceGroupTemplate !== null) {
            throw new TemplateAlreadyHasServiceException($userType->getEn(), $serviceGroup->getId());
        }

        $serviceGroupTemplate = new ServiceGroupTemplate();

        $serviceGroupTemplate->setUserType($userType);
        $serviceGroupTemplate->setServiceGroup($serviceGroup);

        $this->entityManager->persist($serviceGroupTemplate);
        $this->entityManager->flush();

        return $serviceGroupTemplate;
    }
}
