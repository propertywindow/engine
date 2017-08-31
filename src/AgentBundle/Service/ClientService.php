<?php declare(strict_types=1);

namespace AgentBundle\Service;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Entity\Client;

/**
 * @package AgentBundle\Service
 */
class ClientService
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
     * @return Client $client
     */
    public function getClient(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Client');
        $client     = $repository->findById($id);

        return $client;
    }

    /**
     * @param Agent $agent
     *
     * @return Client[]
     */
    public function getClients(Agent $agent)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Client');

        return $repository->listAll($agent);
    }

    /**
     * @param Client $client
     *
     * @return Client
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createClient(Client $client)
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    /**
     * @param Client $client
     *
     * @return Client
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateClient(Client $client)
    {
        $this->entityManager->flush();

        return $client;
    }

    /**
     * @param int $id
     */
    public function deleteClient(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Client');
        $client     = $repository->findById($id);

        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}
