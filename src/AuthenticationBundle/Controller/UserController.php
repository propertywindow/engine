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
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     * @throws Throwable
     * @throws UserAlreadyExistException
     * @throws \AgentBundle\Exceptions\AgentSettingsNotFoundException
     * @throws \AuthenticationBundle\Exceptions\UserSettingsNotFoundException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getUser":
                return $this->getUserById($userId, $parameters);
            case "getUsers":
                return $this->getUsers($userId);
            case "getAgentUsers":
                return $this->getAgentUsers($userId, $parameters);
            case "getColleagues":
                return $this->getColleagues($userId);
            case "createUser":
                return $this->createUser($userId, $parameters);
            case "updateUser":
                return $this->updateUser($userId, $parameters);
            case "setPassword":
                return $this->setPassword($userId, $parameters);
            case "disableUser":
                return $this->disableUser($userId, $parameters);
            case "deleteUser":
                return $this->deleteUser($userId, $parameters);
            case "verify":
                return $this->verify($userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function getUserById(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $id      = (int)$parameters['id'];
        $user    = $this->userService->getUser($id);
        $getUser = $this->userService->getUser($userId);

        $this->isAuthorized($getUser->getAgent()->getId(), $user->getAgent()->getId());

        return Mapper::fromUser($getUser);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getUsers(int $userId)
    {
        $user          = $this->userService->getUser($userId);
        $adminType     = $this->userTypeService->getUserType(1);
        $colleagueType = $this->userTypeService->getUserType(3);
        $users         = $this->userService->getUsers($user, $adminType, $colleagueType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getAgentUsers(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $agent         = $this->agentService->getAgent((int)$parameters['id']);
        $colleagueType = $this->userTypeService->getUserType(3);
        $users         = $this->userService->getAgentUsers($agent, $colleagueType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getColleagues(int $userId)
    {
        $user     = $this->userService->getUser($userId);
        $userType = $this->userTypeService->getUserType(3);
        $agentIds = $this->agentService->getAgentIdsFromGroup($user->getAgent());
        $users    = $this->userService->getColleagues($agentIds, $userType);

        return Mapper::fromUsers(...$users);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     * @throws NotAuthorizedException
     * @throws Throwable
     * @throws UserAlreadyExistException
     * @throws AgentSettingsNotFoundException
     * @throws UserSettingsNotFoundException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    private function createUser(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
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

        $newUser->setEmail(strtolower($parameters['email']));
        $newUser->setFirstName(ucfirst($parameters['first_name']));
        $newUser->setLastName(ucfirst($parameters['last_name']));
        $newUser->setStreet(ucwords($parameters['street']));
        $newUser->setHouseNumber($parameters['house_number']);
        $newUser->setPostcode($parameters['postcode']);
        $newUser->setCity(ucwords($parameters['city']));
        $newUser->setCountry($parameters['country']);
        $newUser->setAgent($user->getAgent());
        $newUser->setUserType($this->userTypeService->getUserType($parameters['user_type_id']));
        $newUser->setActive(false);

        if (array_key_exists('phone', $parameters) && $parameters['phone'] !== null) {
            $newUser->setPhone((string)$parameters['phone']);
        }

        if (array_key_exists('avatar', $parameters) && $parameters['avatar'] !== null) {
            $newUser->setAvatar((string)$parameters['avatar']);
        }

        $createdUser = $this->userService->createUser($newUser);
        $password    = $this->randomPassword();

        $mailParameters = [
            'name'     => $parameters['first_name'],
            'password' => $password,
        ];

        $this->mailerService->sendMail($user, $createdUser->getEmail(), 'user_invite_email', $mailParameters);

        // todo: move new User() from userService to here

        // todo: create user settings, load some settings from agent

        $createdUser->setPassword(md5($password));
        $createdUser->setActive(true);
        $this->userService->updateUser($createdUser);

        return Mapper::fromUser($createdUser);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function updateUser(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user       = $this->userService->getUser($userId);
        $updateUser = $this->userService->getUser((int)$parameters['id']);

        $this->isAuthorized($updateUser->getAgent()->getId(), $user->getAgent()->getId());
        $this->prepareParameters($updateUser, $parameters);

        return Mapper::fromUser($this->userService->updateUser($updateUser));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function setPassword(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
            'password',
        ], $parameters);

        $user       = $this->userService->getUser($userId);
        $updateUser = $this->userService->getUser((int)$parameters['id']);

        $this->isAuthorized($updateUser->getId(), $user->getId());

        $updateUser->setPassword(md5((string)$parameters['password']));
        $updateUser->setActive(true);

        $this->userService->updateUser($updateUser);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function disableUser(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user       = $this->userService->getUser($userId);
        $updateUser = $this->userService->getUser((int)$parameters['id']);

        $this->isAuthorized($updateUser->getAgent()->getId(), $user->getAgent()->getId());

        $this->userService->disableUser($user);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function deleteUser(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        $this->userService->deleteUser((int)$parameters['id']);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function verify(int $userId): array
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromUser($user);
    }
}
