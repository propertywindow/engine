<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\AgentGroup;
use AgentBundle\Exceptions\AgentGroupNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
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
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param int    $userId
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws AgentGroupNotFoundException
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getAgentGroup":
                return $this->getAgentGroup($parameters);
            case "getAgentGroups":
                return $this->getAgentGroups($userId);
            case "createAgentGroup":
                return $this->createAgentGroup($userId, $parameters);
            case "updateAgentGroup":
                return $this->updateAgentGroup($userId, $parameters);
            case "deleteAgentGroup":
                return $this->deleteAgentGroup($userId, $parameters);
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
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromAgentGroup($this->agentGroupService->getAgentGroup($id));
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function getAgentGroups(int $userId)
    {
        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        return Mapper::fromAgentGroups(...$this->agentGroupService->getAgentGroups());
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function createAgentGroup(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        if (!array_key_exists('name', $parameters)) {
            if (!array_key_exists('agent_group_id', $parameters) && $parameters['agent_group_id'] !== null) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }

        $agentGroup = new AgentGroup();

        if (array_key_exists('name', $parameters) && $parameters['name'] !== null) {
            $agentGroup->setName(ucfirst((string)$parameters['name']));
        }

        $this->agentGroupService->createAgentGroup($agentGroup);

        $folder = '../image_data/' . $agentGroup->getId();

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

        return Mapper::fromAgentGroup($agentGroup);
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws AgentGroupNotFoundException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function updateAgentGroup(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters) || empty($parameters['id'])) {
            throw new InvalidArgumentException("Identifier not provided");
        }

        $id          = (int)$parameters['id'];
        $user        = $this->userService->getUser($userId);
        $updateAgent = $this->agentGroupService->getAgentGroup($id);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        if (array_key_exists('name', $parameters) && $parameters['name'] !== null) {
            $updateAgent->setName(ucfirst((string)$parameters['name']));
        }

        return Mapper::fromAgentGroup($this->agentGroupService->updateAgentGroup($updateAgent));
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws AgentGroupNotFoundException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function deleteAgentGroup(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $id = (int)$parameters['id'];

        // todo: check for users and agents before deleting, just warning

        $this->agentGroupService->deleteAgentGroup($id);
    }
}
