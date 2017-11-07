<?php declare(strict_types=1);

namespace AlertBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AlertBundle\Entity\Applicant;
use AlertBundle\Entity\Application;
use AlertBundle\Exceptions\ApplicationNotFoundException;

/**
 * @package AlertBundle\Service
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
        $repository  = $this->entityManager->getRepository('AlertBundle:Application');
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
        $repository  = $this->entityManager->getRepository('AlertBundle:Application');
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
