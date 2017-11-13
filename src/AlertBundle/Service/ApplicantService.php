<?php declare(strict_types=1);

namespace AlertBundle\Service;

use AgentBundle\Entity\AgentGroup;
use Doctrine\ORM\EntityManagerInterface;
use AlertBundle\Entity\Applicant;
use AlertBundle\Exceptions\ApplicantNotFoundException;

/**
 * @package AlertBundle\Service
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
        $repository = $this->entityManager->getRepository('AlertBundle:Applicant');
        $applicant  = $repository->findById($id);

        return $applicant;
    }

    /**
     * @param AgentGroup $agentGroup
     *
     * @return Applicant[]
     */
    public function getApplicants(AgentGroup $agentGroup)
    {
        $repository = $this->entityManager->getRepository('AlertBundle:Applicant');

        return $repository->findByAgent($agentGroup);
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

    /**
     * @param string $email
     *
     * @return Applicant $applicant
     */
    public function getApplicantByEmail(string $email)
    {
        $repository = $this->entityManager->getRepository('AlertBundle:Applicant');
        $applicant  = $repository->findOneBy(['email' => $email]);

        return $applicant;
    }
}
