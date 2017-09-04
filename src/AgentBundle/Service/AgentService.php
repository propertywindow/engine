<?php declare(strict_types=1);

namespace AgentBundle\Service;

use AgentBundle\Entity\AgentGroup;
use Doctrine\ORM\EntityManagerInterface;
use AgentBundle\Entity\Agent;

/**
 * @package AgentBundle\Service
 */
class AgentService
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
     * @return Agent $agent
     */
    public function getAgent(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');
        $agent      = $repository->findById($id);

        return $agent;
    }

    /**
     * @return Agent[]
     */
    public function getAgents()
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');

        return $repository->listAll();
    }

    /**
     * @param int $agentId
     *
     * @return int[] $groupIds
     */
    public function getAgentIdsFromGroup(int $agentId)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:Agent');
        $agent      = $repository->findById($agentId);
        $groupIds   = $repository->getAgentIdsFromGroupId((int)$agent->getAgentGroup()->getId());

        return $groupIds;
    }

    /**
     * @param int $id
     *
     * @return AgentGroup $agentGroup
     */
    public function getAgentGroup(int $id)
    {
        $repository = $this->entityManager->getRepository('AgentBundle:AgentGroup');
        $agentGroup = $repository->findById($id);

        return $agentGroup;
    }


    /**
     * @param array      $parameters
     * @param AgentGroup $agentGroup
     *
     * @return Agent
     */
    public function createAgent(array $parameters, AgentGroup $agentGroup)
    {
        $agent = new Agent();

        $agent->setAgentGroup($agentGroup);
        $agent->setName($parameters['name']);
        $agent->setStreet(ucwords($parameters['street']));
        $agent->setHouseNumber($parameters['house_number']);
        $agent->setPostcode($parameters['postcode']);
        $agent->setCity(ucwords($parameters['city']));
        $agent->setCountry($parameters['country']);
        $agent->setEmail($parameters['email']);

        if (array_key_exists('property_limit', $parameters) && $parameters['property_limit'] !== null) {
            $agent->setPropertyLimit((int)$parameters['property_limit']);
        }
        if (array_key_exists('phone', $parameters) && $parameters['phone'] !== null) {
            $agent->setPhone((string)$parameters['phone']);
        }
        if (array_key_exists('fax', $parameters) && $parameters['fax'] !== null) {
            $agent->setFax((string)$parameters['fax']);
        }
        if (array_key_exists('espc', $parameters) && $parameters['espc'] !== null) {
            $agent->setEspc((bool)$parameters['espc']);
        }
        if (array_key_exists('web_print', $parameters) && $parameters['web_print'] !== null) {
            $agent->setWebprint((bool)$parameters['web_print']);
        }
        if (array_key_exists('logo', $parameters) && $parameters['logo'] !== null) {
            $agent->setLogo((string)$parameters['logo']);
        }
        if (array_key_exists('website', $parameters) && $parameters['website'] !== null) {
            $agent->setWebsite((string)$parameters['website']);
        }

        $this->entityManager->persist($agent);
        $this->entityManager->flush();

        return $agent;
    }

    /**
     * @param int $id
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteAgent(int $id)
    {
        $agentRepository = $this->entityManager->getRepository('AgentBundle:Agent');
        $type            = $agentRepository->findById($id);

        $this->entityManager->remove($type);
        $this->entityManager->flush();
    }
}
