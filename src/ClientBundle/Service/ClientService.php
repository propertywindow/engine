<?php
declare(strict_types = 1);

namespace ClientBundle\Service;

use AgentBundle\Entity\Agent;
use ClientBundle\Exceptions\ClientNotFoundException;
use ClientBundle\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use ClientBundle\Entity\Client;

/**
 * Client Service
 */
class ClientService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Client::class);
    }

    /**
     * @param int $id
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function getClient(int $id): Client
    {
        return $this->repository->findById($id);
    }

    /**
     * @param Agent $agent
     *
     * @return Client[]
     */
    public function getClients(Agent $agent): array
    {
        return $this->repository->listAll($agent);
    }

    /**
     * @param Client $client
     *
     * @return Client
     */
    public function createClient(Client $client): Client
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    /**
     * @param Client $client
     *
     * @return Client
     */
    public function updateClient(Client $client)
    {
        $this->entityManager->flush();

        return $client;
    }

    /**
     * @param int $id
     *
     * @throws ClientNotFoundException
     */
    public function deleteClient(int $id)
    {
        $client = $this->repository->findById($id);

        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}
