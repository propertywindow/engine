<?php
declare(strict_types = 1);

namespace AlertBundle\Service;

use AlertBundle\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use AlertBundle\Entity\Applicant;
use AlertBundle\Entity\Application;
use AlertBundle\Exceptions\ApplicationNotFoundException;

/**
 * Application Service
 */
class ApplicationService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ApplicationRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Application::class);
    }

    /**
     * @param int $id
     *
     * @return Application
     * @throws ApplicationNotFoundException
     */
    public function getApplication(int $id): Application
    {
        return $this->repository->findById($id);
    }

    /**
     * @param Applicant $applicant
     *
     * @return Application[]
     */
    public function getApplicationFromApplicant(Applicant $applicant): array
    {
        return $this->repository->findByApplicant($applicant);
    }

    /**
     * @param Application $application
     *
     * @return Application
     */
    public function createApplication(Application $application): Application
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
    public function updateApplication(Application $application): Application
    {
        $this->entityManager->flush();

        return $application;
    }
}
