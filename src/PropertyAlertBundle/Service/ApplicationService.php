<?php declare(strict_types=1);

namespace PropertyAlertBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyAlertBundle\Entity\Applicant;
use PropertyAlertBundle\Entity\Application;
use PropertyAlertBundle\Exceptions\ApplicationNotFoundException;

/**
 * @package PropertyAlertBundle\Service
 */
class ApplicationService
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
     * @return Application $application
     *
     * @throws ApplicationNotFoundException
     */
    public function getApplication(int $id)
    {
        $repository  = $this->entityManager->getRepository('PropertyAlertBundle:Application');
        $application = $repository->findById($id);

        return $application;
    }

    /**
     * @param Applicant $applicant
     *
     * @return Application $application
     *
     * @throws ApplicationNotFoundException
     */
    public function getApplicationFromApplicant(Applicant $applicant)
    {
        $repository  = $this->entityManager->getRepository('PropertyAlertBundle:Application');
        $application = $repository->findByApplicant($applicant);

        return $application;
    }

    /**
     * @param Application $application
     *
     * @return Application
     */
    public function createApplication(Application $application)
    {
        $this->entityManager->persist($application);
        $this->entityManager->flush();

        return $application;
    }

    /**
     * @param Application $application
     *
     * @return Application
     */
    public function updateApplication(Application $application)
    {
        $this->entityManager->flush();

        return $application;
    }
}
