<?php declare(strict_types=1);

namespace AlertBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AlertBundle\Entity\Applicant;
use AlertBundle\Exceptions\ApplicantNotFoundException;

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
