<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Entity\ServiceTemplate;
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
     * @param int $id
     * @param int $userTypeId
     *
     * @return ServiceTemplate $serviceTemplate
     *
     * @throws TemplateNotFoundException
     */
    public function getServiceTemplate(int $id, int $userTypeId)
    {
        $repository      = $this->entityManager->getRepository('AuthenticationBundle:ServiceTemplate');
        $serviceTemplate = $repository->find($id);

        /** @var ServiceTemplate $serviceTemplate */
        if ($serviceTemplate === null) {
            throw new TemplateNotFoundException($id);
        }

        return $serviceTemplate;
    }
}
