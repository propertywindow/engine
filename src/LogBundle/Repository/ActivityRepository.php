<?php declare(strict_types=1);

namespace LogBundle\Repository;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use LogBundle\Entity\Activity;
use LogBundle\Exceptions\ActivityNotFoundException;

/**
 * ActivityRepository
 *
 */
class ActivityRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Activity
     * @throws ActivityNotFoundException
     */
    public function findById(int $id): Activity
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ActivityNotFoundException($id);
        }

        /** @var Activity $result */
        return $result;
    }

    /**
     * @param User $user
     *
     * @return Activity[]
     */
    public function findByUser(User $user): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('a')
                   ->from('LogBundle:Activity', 'a')
                   ->where("a.user = :user")
                   ->setParameter('user', $user)
                   ->orderBy('a.created', 'DESC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }

    /**
     * @param Agent $agent
     *
     * @return Activity[]
     */
    public function findByAgent(Agent $agent): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('a')
                   ->from('LogBundle:Activity', 'a')
                   ->where("a.agent = :agent")
                   ->setParameter('agent', $agent)
                   ->orderBy('a.created', 'DESC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
