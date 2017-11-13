<?php declare(strict_types=1);

namespace AlertBundle\Service\Applicant;

use AlertBundle\Entity\Applicant;

/**
 * Class Mapper
 * @package AlertBundle\Service\Applicant
 */
class Mapper
{
    /**
     * @param Applicant $applicant
     *
     * @return array
     */
    public static function fromApplicant(Applicant $applicant): array
    {
        return [
            'id'             => $applicant->getId(),
            'agent_group_id' => $applicant->getAgentGroup()->getId(),
            'name'           => $applicant->getName(),
            'country'        => $applicant->getCountry(),
            'email'          => $applicant->getEmail(),
            'phone'          => $applicant->getPhone(),
            'protection'     => $applicant->getProtection(),
        ];
    }

    /**
     * @param Applicant[] ...$applicants
     *
     * @return array
     */
    public static function fromApplicants(Applicant ...$applicants): array
    {
        return array_map(
            function (Applicant $applicant) {
                return self::fromApplicant($applicant);
            },
            $applicants
        );
    }
}
