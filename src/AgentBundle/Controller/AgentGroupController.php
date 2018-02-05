<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\AgentGroup;
use AgentBundle\Exceptions\AgentGroupNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Service\AgentGroup\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AgentBundle\Controller\AgentGroupController")
 */
class AgentGroupController extends BaseController
{
    /**
     * @Route("/agent_group" , name="agent_group")
     * @param Request $httpRequest
     *
     * @return HttpResponse
     * @throws Throwable
     */
    public function requestHandler(Request $httpRequest)
    {
        try {
            list($method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(string $method, array $parameters = [])
    {
        if (is_callable([$this, $method])) {
            return $this->$method($parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws AgentGroupNotFoundException
     */
    private function getAgentGroup(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        return Mapper::fromAgentGroup($this->agentGroupService->getAgentGroup((int)$parameters['id']));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getAgentGroups()
    {
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        return Mapper::fromAgentGroups(...$this->agentGroupService->getAgentGroups());
    }

    /**
     * @param array $parameters
     *
     * @return array $user
     * @throws NotAuthorizedException
     */
    private function createAgentGroup(array $parameters)
    {
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        if (!array_key_exists('name', $parameters)) {
            if (!array_key_exists('agent_group_id', $parameters) && $parameters['agent_group_id'] !== null) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }

        $agentGroup = new AgentGroup();

        $this->prepareParameters($agentGroup, $parameters);

        $this->agentGroupService->createAgentGroup($agentGroup);

        $this->createFolders($agentGroup->getId());

        return Mapper::fromAgentGroup($agentGroup);
    }


    /**
     * @param array $parameters
     *
     * @return array
     * @throws AgentGroupNotFoundException
     * @throws NotAuthorizedException
     */
    private function updateAgentGroup(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $updateAgent = $this->agentGroupService->getAgentGroup((int)$parameters['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        if (array_key_exists('name', $parameters) && $parameters['name'] !== null) {
            $updateAgent->setName(ucfirst((string)$parameters['name']));
        }

        return Mapper::fromAgentGroup($this->agentGroupService->updateAgentGroup($updateAgent));
    }


    /**
     * @param array $parameters
     *
     * @throws AgentGroupNotFoundException
     * @throws NotAuthorizedException
     */
    private function deleteAgentGroup(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        // todo: check for users and agents before deleting, just warning
        // todo: delete folders

        $this->agentGroupService->deleteAgentGroup((int)$parameters['id']);
    }

    /**
     * @param int $agentGroupId
     */
    private function createFolders(int $agentGroupId)
    {
        $folder = '../image_data/' . $agentGroupId;

        if (!file_exists($folder)) {
            $createFolders = [
                $folder,
                $folder . '/logo',
                $folder . '/properties',
                $folder . '/users',
            ];

            foreach ($createFolders as $createFolder) {
                $oldMask = umask(0);
                mkdir($createFolder, 0777);
                umask($oldMask);
            }
        }
    }
}
