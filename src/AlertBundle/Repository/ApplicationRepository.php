<?php declare(strict_types = 1);

namespace AlertBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AlertBundle\Entity\Applicant;
use AlertBundle\Entity\Application;
use AlertBundle\Exceptions\ApplicationNotFoundException;

/**
 * ApplicationRepository
 */
class ApplicationRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Application
     * @throws ApplicationNotFoundException
     */
    public function findById(int $id): Application
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ApplicationNotFoundException($id);
        }

        /** @var Application $result */
        return $result;
    }

    /**
     * @param Applicant $applicant
     *
     * @return Application[]
     */
    public function findByApplicant(Applicant $applicant): array
    {
        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('AlertBundle:Application', 'a')
            ->where("a.applicant = :applicant")
            ->setParameter('applicant', $applicant)
            ->orderBy('a.created', 'DESC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
