<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\Service;
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
}
