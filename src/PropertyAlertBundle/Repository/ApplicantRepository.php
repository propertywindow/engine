<?php declare(strict_types=1);

namespace PropertyAlertBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyAlertBundle\Entity\Applicant;
use PropertyAlertBundle\Exceptions\ApplicantNotFoundException;

/**
 * ApplicantRepository
 *
 */
class ApplicantRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Applicant
     *
     * @throws ApplicantNotFoundException
     */
    public function findById(int $id): Applicant
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ApplicantNotFoundException($id);
        }

        /** @var Applicant $result */
        return $result;
    }
}
