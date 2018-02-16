<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Controller;

use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AppBundle\Controller\JsonController;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use AuthenticationBundle\Exceptions\UserTypeNotFoundException;
use AuthenticationBundle\Service\User\Mapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\UserController")
 */
class UserController extends JsonController
{
    /**
     * @Route("/authentication/user" , name="user")
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
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function getUserById(): array
    {
        $this->checkParameters(['id']);

        $user = $this->userService->getUser((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $user->getAgent()->getId());

        return Mapper::fromUser($this->user);
    }

    /**
     * @return array
     * @throws UserTypeNotFoundException
     */
    private function getUsers(): array
    {
        $adminType     = $this->userTypeService->getUserType(1);
        $colleagueType = $this->userTypeService->getUserType(3);
        $users         = $this->userService->getUsers($this->user, $adminType, $colleagueType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @return array
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     * @throws UserTypeNotFoundException
     */
    private function getAgentColleagues(): array
    {
        $this->hasAccessLevel(self::USER_ADMIN);

        $this->checkParameters(['id']);

        $agent         = $this->agentService->getAgent((int)$this->parameters['id']);
        $colleagueType = $this->userTypeService->getUserType(3);
        $users         = $this->userService->getAgentColleagues($agent, $colleagueType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @return array
     * @throws UserTypeNotFoundException
     */
    private function getColleagues(): array
    {
        $userType = $this->userTypeService->getUserType(3);
        $agentIds = $this->agentService->getAgentIdsFromGroup($this->user->getAgent());
        $users    = $this->userService->getAllColleagues($agentIds, $userType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @return array $user
     * @throws AgentSettingsNotFoundException
     * @throws NotAuthorizedException
     * @throws Throwable
     * @throws UserAlreadyExistException
     * @throws UserSettingsNotFoundException
     * @throws UserTypeNotFoundException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    private function createUser()
    {
        $this->hasAccessLevel(self::USER_AGENT);

        $this->checkParameters([
            'email',
            'first_name',
            'last_name',
            'street',
            'house_number',
            'postcode',
            'city',
            'country',
            'agent_id',
            'user_type_id',
        ]);

        if ($this->userService->getUserByEmail($this->parameters['email'])) {
            throw new UserAlreadyExistException($this->parameters['email']);
        }

        $newUser = new User();
        $newUser->setAgent($this->user->getAgent());
        $newUser->setUserType($this->userTypeService->getUserType($this->parameters['user_type_id']));
        $newUser->setActive(false);
        $newUser->setAddress($this->createAddress());

        $this->prepareParameters($newUser);

        $createdUser = $this->userService->createUser($newUser);
        $password    = $this->generatePassword();

        $mailParameters = [
            'name'     => $this->parameters['first_name'],
            'password' => $password,
        ];

        $this->mailerService->sendMail($this->user, $createdUser->getEmail(), 'user_invite_email', $mailParameters);

        // todo: move new User() from userService to here

        // todo: create user settings, load some settings from agent

        $createdUser->setPassword(md5($password));
        $createdUser->setActive(true);
        $this->userService->updateUser($createdUser);

        return Mapper::fromUser($createdUser);
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function updateUser()
    {
        $this->checkParameters(['id']);

        $updateUser = $this->userService->getUser((int)$this->parameters['id']);

        $this->isAuthorized($updateUser->getAgent()->getId(), $this->user->getAgent()->getId());

        $updateUser->setAddress($this->createAddress());

        $this->prepareParameters($updateUser);

        return Mapper::fromUser($this->userService->updateUser($updateUser));
    }

    /**
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function setPassword()
    {
        $this->checkParameters([
            'id',
            'password',
        ]);

        $updateUser = $this->userService->getUser((int)$this->parameters['id']);

        $this->isAuthorized($updateUser->getId(), $this->user->getId());

        $updateUser->setPassword(md5((string)$this->parameters['password']));
        $updateUser->setActive(true);

        $this->userService->updateUser($updateUser);
    }

    /**
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function disableUser()
    {
        $this->checkParameters(['id']);

        $updateUser = $this->userService->getUser((int)$this->parameters['id']);

        $this->isAuthorized($updateUser->getAgent()->getId(), $this->user->getAgent()->getId());

        $this->userService->disableUser($this->user);
    }

    /**
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function deleteUser()
    {
        $this->checkParameters(['id']);

        $this->hasAccessLevel(self::USER_AGENT);

        $this->userService->deleteUser((int)$this->parameters['id']);
    }

    /**
     * @return array
     */
    private function verify(): array
    {
        return Mapper::fromUser($this->user);
    }

    /**
     * @return array|null
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     * @throws UserTypeNotFoundException
     */
    private function getApiUser(): ?array
    {
        $this->hasAccessLevel(self::USER_AGENT);

        if ($this->user->getUserType() === self::USER_ADMIN) {
            $this->checkParameters(['agent_id']);
            $agent = $this->agentService->getAgent($this->parameters['agent_id']);
        } else {
            $agent = $this->user->getAgent();
        }

        $userType = $this->userTypeService->getUserType(5);
        $user     = $this->userService->getApiUser($agent, $userType);

        if ($user) {
            return [
                'id'     => $user->getId(),
                'active' => $user->getActive(),
                'token'  => $this->generateToken($user),
            ];
        } else {
            return [
                'id'     => null,
                'active' => false,
                'token'  => null,
            ];
        }
    }

    /**
     * @return string
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     * @throws UserTypeNotFoundException
     */
    private function createApiUser(): string
    {
        $this->hasAccessLevel(self::USER_AGENT);

        if ($this->user->getUserType() === self::USER_ADMIN) {
            $this->checkParameters(['agent_id']);
            $agent = $this->agentService->getAgent($this->parameters['agent_id']);
        } else {
            $agent = $this->user->getAgent();
        }

        $userType = $this->userTypeService->getUserType(5);
        $user     = $this->userService->getApiUser($agent, $userType);

        if (!$user) {
            $newUser = new User();

            $newUser->setAgent($agent);
            $newUser->setUserType($userType);
            $newUser->setEmail($this->generateEmail());
            $newUser->setPassword(md5($this->generatePassword()));
            $newUser->setFirstName($agent->getUser()->getFirstName());
            $newUser->setLastName($agent->getUser()->getLastName());
            $newUser->setPhone($agent->getPhone());
            $newUser->setActive(true);

            $user = $this->userService->createUser($newUser);

            // todo: add services to view properties and create property alerts
        }

        return $this->generateToken($user);
    }
}
