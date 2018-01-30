<?php
declare(strict_types=1);

namespace AlertBundle\Service;

use AgentBundle\Entity\AgentGroup;
use AlertBundle\Repository\ApplicantRepository;
use Doctrine\ORM\EntityManagerInterface;
use AlertBundle\Entity\Applicant;
use AlertBundle\Exceptions\ApplicantNotFoundException;

/**
 * Applicant Service
 */
class ApplicantService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ApplicantRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Applicant::class);
    }

    /**
     * @param int $id
     *
     * @return Applicant
     * @throws ApplicantNotFoundException
     */
    public function getApplicant(int $id): Applicant
    {
        return $this->repository->findById($id);
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return Applicant[]
     */
    public function getApplicants(AgentGroup $agentGroup): array
    {
        return $this->repository->findByAgent($agentGroup);
    }

    /**
     * @param Applicant $applicant
     *
     * @return Applicant
     */
    public function createApplicant(Applicant $applicant): Applicant
    {
        $this->entityManager->persist($applicant);
        $this->entityManager->flush();

        return $applicant;
    }

    /**
     * @param Applicant $applicant
     *
     * @return Applicant
     */
    public function updateApplicant(Applicant $applicant): Applicant
    {
        $this->entityManager->flush();

        return $applicant;
    }

    /**
     * @param string $email
     *
     * @return Applicant
     */
    public function getApplicantByEmail(string $email): Applicant
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}
