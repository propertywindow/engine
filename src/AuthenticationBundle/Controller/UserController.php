<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use AuthenticationBundle\Exceptions\UserTypeNotFoundException;
use AuthenticationBundle\Service\User\Mapper;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\UserController")
 */
class UserController extends BaseController
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
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function getUserById(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user = $this->userService->getUser((int)$parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $user->getAgent()->getId());

        return Mapper::fromUser($this->user);
    }

    /**
     * @return array
     * @throws UserTypeNotFoundException
     */
    private function getUsers()
    {
        $adminType     = $this->userTypeService->getUserType(1);
        $colleagueType = $this->userTypeService->getUserType(3);
        $users         = $this->userService->getUsers($this->user, $adminType, $colleagueType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     * @throws UserTypeNotFoundException
     */
    private function getAgentUsers(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $agent         = $this->agentService->getAgent((int)$parameters['id']);
        $colleagueType = $this->userTypeService->getUserType(3);
        $users         = $this->userService->getAgentUsers($agent, $colleagueType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @return array
     * @throws UserTypeNotFoundException
     */
    private function getColleagues()
    {
        $userType = $this->userTypeService->getUserType(3);
        $agentIds = $this->agentService->getAgentIdsFromGroup($this->user->getAgent());
        $users    = $this->userService->getColleagues($agentIds, $userType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @param array $parameters
     *
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
    private function createUser(array $parameters)
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
        ], $parameters);

        if (!filter_var($parameters['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("email parameter not valid");
        }

        if ($this->userService->getUserByEmail($parameters['email'])) {
            throw new UserAlreadyExistException($parameters['email']);
        }

        $newUser = new User();
        $newUser->setAgent($this->user->getAgent());
        $newUser->setUserType($this->userTypeService->getUserType($parameters['user_type_id']));
        $newUser->setActive(false);

        $this->prepareParameters($newUser, $parameters);

        $createdUser = $this->userService->createUser($newUser);
        $password    = $this->randomPassword();

        $mailParameters = [
            'name'     => $parameters['first_name'],
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
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function updateUser(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $updateUser = $this->userService->getUser((int)$parameters['id']);

        $this->isAuthorized($updateUser->getAgent()->getId(), $this->user->getAgent()->getId());
        $this->prepareParameters($updateUser, $parameters);

        return Mapper::fromUser($this->userService->updateUser($updateUser));
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function setPassword(array $parameters)
    {
        $this->checkParameters([
            'id',
            'password',
        ], $parameters);

        $updateUser = $this->userService->getUser((int)$parameters['id']);

        $this->isAuthorized($updateUser->getId(), $this->user->getId());

        $updateUser->setPassword(md5((string)$parameters['password']));
        $updateUser->setActive(true);

        $this->userService->updateUser($updateUser);
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function disableUser(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $updateUser = $this->userService->getUser((int)$parameters['id']);

        $this->isAuthorized($updateUser->getAgent()->getId(), $this->user->getAgent()->getId());

        $this->userService->disableUser($this->user);
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function deleteUser(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        if ($this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        $this->userService->deleteUser((int)$parameters['id']);
    }

    /**
     * @return array
     */
    private function verify(): array
    {
        return Mapper::fromUser($this->user);
    }
}
