<?php declare(strict_types=1);

namespace AlertBundle\Repository;

use AgentBundle\Entity\AgentGroup;
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

    /**
     * @param AgentGroup $agentGroup
     *
     * @return Applicant[]
     */
    public function findByAgent(AgentGroup $agentGroup): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('a')
                   ->from('AlertBundle:Applicant', 'a')
                   ->where("a.agentGroup = :agentGroup")
                   ->setParameter('agentGroup', $agentGroup)
                   ->orderBy('a.created', 'DESC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
