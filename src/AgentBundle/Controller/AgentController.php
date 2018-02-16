<?php
declare(strict_types = 1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Agent;
use AgentBundle\Exceptions\AgentGroupNotFoundException;
use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AppBundle\Controller\JsonController;
use AppBundle\Entity\ContactAddress;
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
class AgentController extends JsonController
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
            $method          = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($method));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param string $method
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(string $method)
    {
        if (is_callable([$this, $method])) {
            return $this->$method();
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @return array
     * @throws AgentNotFoundException
     */
    private function getAgent(): array
    {
        $this->checkParameters(['id']);

        return Mapper::fromAgent($this->agentService->getAgent((int)$this->parameters['id']));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getAgents(): array
    {
        $this->hasAccessLevel(self::USER_ADMIN);

        return Mapper::fromAgents(...$this->agentService->getAgents());
    }

    /**
     * @return array
     * @throws AgentGroupNotFoundException
     * @throws NotAuthorizedException
     * @throws Throwable
     * @throws UserAlreadyExistException
     * @throws AgentSettingsNotFoundException
     * @throws UserSettingsNotFoundException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    private function createAgent(): array
    {
        $this->hasAccessLevel(self::USER_ADMIN);

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
        ]);

        if (!array_key_exists('agent_group_id', $this->parameters)) {
            if (!array_key_exists('name', $this->parameters) && $this->parameters['name'] !== null) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }

        if (!array_key_exists('name', $this->parameters)) {
            if (!array_key_exists('agent_group_id', $this->parameters) &&
                $this->parameters['agent_group_id'] !== null
            ) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }

        if ($this->userService->getUserByEmail($this->parameters['email'])) {
            throw new UserAlreadyExistException($this->parameters['email']);
        }

        $agent   = new Agent();
        $address = $this->createAddress();

        $agent->setAddress($address);
        $agent->setAgentGroup($this->agentGroupService->getAgentGroup($this->parameters['agent_group_id']));
        unset($this->parameters['agent_group_id']);

        $this->prepareParameters($agent);

        $this->agentService->createAgent($agent);

        $newUser = new User();

        $newUser->setAgent($agent);
        $newUser->setUserType($this->userTypeService->getUserType(2));
        $newUser->setActive(false);
        $newUser->setAddress($address);

        $this->prepareParameters($newUser);

        $createdUser = $this->userService->createUser($newUser);
        $password    = $this->generatePassword();

        // todo: set services for user
        // todo: add to settings entity

        $mailParameters = [
            'name'     => $this->parameters['first_name'],
            'password' => $password,
        ];

        $this->mailerService->sendMail($this->user, $createdUser->getEmail(), 'user_invite_email', $mailParameters);

        $createdUser->setPassword(md5($password));
        $this->userService->updateUser($createdUser);

        $agent->setUser($createdUser);
        $this->agentService->updateAgent($agent);

        // todo: also set serviceGroupMap and serviceMap, do this in serviceMapService -> wizard saves during each step
        // todo:  $createdUser->setActive(true); and agent active after services are set.

        return Mapper::fromAgent($agent);
    }

    /**
     * @return array
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     */
    private function updateAgent(): array
    {
        $this->checkParameters(['id']);

        $agent = $this->agentService->getAgent((int)$this->parameters['id']);

        $this->hasAccessLevel(self::USER_AGENT);

        if ($agent->getId() !== $this->user->getAgent()->getId()) {
            $this->hasAccessLevel(self::USER_ADMIN);
        }

        $agent->setAddress($this->createAddress());

        $this->prepareParameters($agent);

        return Mapper::fromAgent($this->agentService->updateAgent($agent));
    }

    /**
     * @throws NotAuthorizedException
     * @throws AgentNotFoundException
     */
    private function deleteAgent()
    {
        $this->checkParameters(['id']);

        $this->hasAccessLevel(self::USER_ADMIN);

        // todo: check for users (colleagues) and properties before deleting, just warning

        $this->agentService->deleteAgent((int)$this->parameters['id']);
    }
}
