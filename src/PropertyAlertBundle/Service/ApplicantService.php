<?php declare(strict_types=1);

namespace PropertyAlertBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyAlertBundle\Entity\Applicant;
use PropertyAlertBundle\Exceptions\ApplicantNotFoundException;

/**
 * @package PropertyAlertBundle\Service
 */
class ApplicantService
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
     * @return Applicant $applicant
     *
     * @throws ApplicantNotFoundException
     */
    public function getApplicant(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyAlertBundle:Applicant');
        $applicant  = $repository->findById($id);

        return $applicant;
    }

    /**
     * @param Applicant $applicant
     *
     * @return Applicant
     */
    public function createApplicant(Applicant $applicant)
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
    public function updateApplicant(Applicant $applicant)
    {
        $this->entityManager->flush();

        return $applicant;
    }
}
