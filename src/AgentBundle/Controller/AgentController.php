<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Agent;
use AgentBundle\Exceptions\AgentGroupNotFoundException;
use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Service\Agent\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AgentBundle\Controller\AgentController")
 */
class AgentController extends BaseController
{
    /**
     * @Route("/agent" , name="agent")
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
     * @throws AgentNotFoundException
     */
    private function getAgent(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        return Mapper::fromAgent($this->agentService->getAgent((int)$parameters['id']));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getAgents()
    {
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        return Mapper::fromAgents(...$this->agentService->getAgents());
    }

    /**
     * @param array $parameters
     *
     * @return array $user
     * @throws AgentGroupNotFoundException
     * @throws NotAuthorizedException
     * @throws Throwable
     * @throws UserAlreadyExistException
     * @throws AgentSettingsNotFoundException
     * @throws UserSettingsNotFoundException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    private function createAgent(array $parameters)
    {
        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $this->checkParameters([
            'office',
            'email',
            'first_name',
            'last_name',
            'street',
            'house_number',
            'postcode',
            'city',
            'country',
        ], $parameters);

        if (!array_key_exists('agent_group_id', $parameters)) {
            if (!array_key_exists('name', $parameters) && $parameters['name'] !== null) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }

        if (!array_key_exists('name', $parameters)) {
            if (!array_key_exists('agent_group_id', $parameters) && $parameters['agent_group_id'] !== null) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }

        if ($this->userService->getUserByEmail($parameters['email'])) {
            throw new UserAlreadyExistException($parameters['email']);
        }

        $agent = new Agent();

        $agent->setAgentGroup($this->agentGroupService->getAgentGroup($parameters['agent_group_id']));
        unset($parameters['agent_group_id']);

        $this->prepareParameters($agent, $parameters);

        $this->agentService->createAgent($agent);

        $newUser = new User();

        $newUser->setAgent($agent);
        $newUser->setUserType($this->userTypeService->getUserType(2));
        $newUser->setActive(false);

        $this->prepareParameters($newUser, $parameters);

        $createdUser = $this->userService->createUser($newUser);
        $password    = $this->randomPassword();

        $mailParameters = [
            'name'     => $parameters['first_name'],
            'password' => $password,
        ];

        $this->mailerService->sendMail($this->user, $createdUser->getEmail(), 'user_invite_email', $mailParameters);

        $createdUser->setPassword(md5($password));
        $this->userService->updateUser($createdUser);

        $agent->setUserId($createdUser->getId());
        $this->agentService->updateAgent($agent);

        // todo: also set serviceGroupMap and serviceMap, do this in serviceMapService -> wizard saves during each step
        // todo:  $createdUser->setActive(true); and agent active after services are set.

        return Mapper::fromAgent($agent);
    }


    /**
     * @param array $parameters
     *
     * @return array
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     */
    private function updateAgent(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $agent = $this->agentService->getAgent((int)$parameters['id']);

        if ((int)$this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        if ($agent->getId() !== $this->user->getAgent()->getId()) {
            $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);
        }

        $this->prepareParameters($agent, $parameters);

        // todo: also update user with new address, only on address change

        return Mapper::fromAgent($this->agentService->updateAgent($agent));
    }


    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws AgentNotFoundException
     */
    private function deleteAgent(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        // todo: check for users (colleagues) and properties before deleting, just warning

        $this->agentService->deleteAgent((int)$parameters['id']);
    }
}
