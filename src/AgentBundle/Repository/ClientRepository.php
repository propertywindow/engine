<?php declare(strict_types=1);

namespace AgentBundle\Repository;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Client;
use AgentBundle\Exceptions\ClientNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 *
 */
class ClientRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function findById(int $id): Client
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ClientNotFoundException($id);
        }

        /** @var Client $result */
        return $result;
    }

    /**
     * @param Agent $agent
     *
     * @return Client[]
     */
    public function listAll(Agent $agent): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
                   ->select('s')
                   ->from('AgentBundle:Client', 'c');

        if (!empty($typeId)) {
            $qb->where("c.agent = :agent");
            $qb->setParameter('agent', $agent);
        }

        $qb->orderBy('c.id', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
