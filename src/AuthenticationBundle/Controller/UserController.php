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

        $user = $this->userService->getUser((int) $this->parameters['id']);

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
    private function getAgentUsers(): array
    {
        $this->checkParameters(['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $agent         = $this->agentService->getAgent((int) $this->parameters['id']);
        $colleagueType = $this->userTypeService->getUserType(3);
        $users         = $this->userService->getAgentUsers($agent, $colleagueType);

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
        $users    = $this->userService->getColleagues($agentIds, $userType);

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
        if ($this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

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

        $this->prepareParameters($newUser);

        $createdUser = $this->userService->createUser($newUser);
        $password    = $this->randomPassword();

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

        $updateUser = $this->userService->getUser((int) $this->parameters['id']);

        $this->isAuthorized($updateUser->getAgent()->getId(), $this->user->getAgent()->getId());
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

        $updateUser = $this->userService->getUser((int) $this->parameters['id']);

        $this->isAuthorized($updateUser->getId(), $this->user->getId());

        $updateUser->setPassword(md5((string) $this->parameters['password']));
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

        $updateUser = $this->userService->getUser((int) $this->parameters['id']);

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

        if ($this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        $this->userService->deleteUser((int) $this->parameters['id']);
    }

    /**
     * @return array
     */
    private function verify(): array
    {
        return Mapper::fromUser($this->user);
    }
}
