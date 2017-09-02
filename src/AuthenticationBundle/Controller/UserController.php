<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AgentBundle\Service\AgentService;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Service\User\Mapper;
use AuthenticationBundle\Service\UserService;
use AuthenticationBundle\Service\UserTypeService;
use Exception;
use InvalidArgumentException;
use LogBundle\Service\MailService;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Security\Authenticator;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="user_controller")
 */
class UserController extends Controller
{
    private const         PARSE_ERROR            = -32700;
    private const         INVALID_REQUEST        = -32600;
    private const         METHOD_NOT_FOUND       = -32601;
    private const         INVALID_PARAMS         = -32602;
    private const         INTERNAL_ERROR         = -32603;
    private const         USER_NOT_AUTHENTICATED = -32000;
    private const         USER_NOT_FOUND         = -32001;
    private const         USER_ADMIN             = 1;
    private const         USER_AGENT             = 2;
    private const         USER_COLLEAGUE         = 3;
    private const         USER_CLIENT            = 4;
    private const         USER_API               = 5;
    private const         EMAIL_FROM_EMAIL       = 'no-reply@propertywindow.nl';
    private const         EMAIL_FROM_NAME        = 'Property Window';

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var AgentService
     */
    private $agentService;

    /**
     * @var UserTypeService
     */
    private $userTypeService;

    /**
     * @var MailService
     */
    private $mailService;

    /**
     * @param Authenticator   $authenticator
     * @param UserService     $userService
     * @param AgentService    $agentService
     * @param UserTypeService $userTypeService
     * @param MailService     $mailService
     */
    public function __construct(
        Authenticator $authenticator,
        UserService $userService,
        AgentService $agentService,
        UserTypeService $userTypeService,
        MailService $mailService
    ) {
        $this->authenticator   = $authenticator;
        $this->userService     = $userService;
        $this->agentService    = $agentService;
        $this->userTypeService = $userTypeService;
        $this->mailService     = $mailService;
    }

    /**
     * @Route("/authentication/user" , name="user")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     */
    public function requestHandler(Request $httpRequest)
    {
        $id = null;
        try {
            $userId = $this->authenticator->authenticate($httpRequest);

            $jsonString = file_get_contents('php://input');
            $jsonArray  = json_decode($jsonString, true);

            if ($jsonArray === null) {
                throw new CouldNotParseJsonRequestException("Could not parse JSON-RPC request");
            }

            if ($jsonArray['jsonrpc'] !== '2.0') {
                throw new InvalidJsonRpcRequestException("Request does not match JSON-RPC 2.0 specification");
            }

            $id     = $jsonArray['id'];
            $method = $jsonArray['method'];
            if (empty($method)) {
                throw new InvalidJsonRpcMethodException("No request method found");
            }

            $parameters = [];
            if (array_key_exists('params', $jsonArray)) {
                $parameters = $jsonArray['params'];
            }

            $jsonRpcResponse = Response::success($id, $this->invoke($userId, $method, $parameters));
        } catch (CouldNotParseJsonRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::PARSE_ERROR, $ex->getMessage()));
        } catch (InvalidJsonRpcRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_REQUEST, $ex->getMessage()));
        } catch (InvalidJsonRpcMethodException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::METHOD_NOT_FOUND, $ex->getMessage()));
        } catch (InvalidArgumentException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_PARAMS, $ex->getMessage()));
        } catch (CouldNotAuthenticateUserException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::USER_NOT_AUTHENTICATED, $ex->getMessage()));
        } catch (UserNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::USER_NOT_FOUND, $ex->getMessage()));
        } catch (Exception $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INTERNAL_ERROR, $ex->getMessage()));
        }

        $httpResponse = HttpResponse::create(
            json_encode($jsonRpcResponse),
            200,
            [
                'Content-Type' => 'application/json',
            ]
        );

        return $httpResponse;
    }

    /**
     * @param int    $userId
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     * @throws UserNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getUser":
                return $this->getUserById($userId, $parameters);
            case "getUsers":
                return $this->getUsers($userId);
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
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getUserById(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id      = (int)$parameters['id'];
        $user    = $this->userService->getUser($id);
        $getUser = $this->userService->getUser($userId);

        if ($getUser->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromUser($getUser);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getUsers(int $userId)
    {
        $user  = $this->userService->getUser($userId);
        $users = $this->userService->getUsers($user->getAgent());

        return Mapper::fromUsers(...$users);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     *
     * @throws NotAuthorizedException
     * @throws UserAlreadyExistException
     */
    private function createUser(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() >= self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        if (!array_key_exists('email', $parameters) && $parameters['email'] !== null) {
            throw new InvalidArgumentException("email parameter not provided");
        }
        if (!filter_var($parameters['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("email parameter not valid");
        }
        if (!array_key_exists('first_name', $parameters) && $parameters['first_name'] !== null) {
            throw new InvalidArgumentException("first_name parameter not provided");
        }
        if (!array_key_exists('last_name', $parameters) && $parameters['last_name'] !== null) {
            throw new InvalidArgumentException("last_name parameter not provided");
        }
        if (!array_key_exists('street', $parameters) && $parameters['street'] !== null) {
            throw new InvalidArgumentException("street parameter not provided");
        }
        if (!array_key_exists('house_number', $parameters) && $parameters['house_number'] !== null) {
            throw new InvalidArgumentException("house_number parameter not provided");
        }
        if (!array_key_exists('postcode', $parameters) && $parameters['postcode'] !== null) {
            throw new InvalidArgumentException("postcode parameter not provided");
        }
        if (!array_key_exists('city', $parameters) && $parameters['city'] !== null) {
            throw new InvalidArgumentException("city parameter not provided");
        }
        if (!array_key_exists('country', $parameters) && $parameters['country'] !== null) {
            throw new InvalidArgumentException("country parameter not provided");
        }
        if (!array_key_exists('agent_id', $parameters) && $parameters['agent_id'] !== null) {
            throw new InvalidArgumentException("agent_id parameter not provided");
        }
        if (!array_key_exists('user_type_id', $parameters) && $parameters['user_type_id'] !== null) {
            throw new InvalidArgumentException("user_type_id parameter not provided");
        }

        if ($this->userService->getUserByEmail($parameters['email'])) {
            throw new UserAlreadyExistException($parameters['email']);
        }

        $userType    = $this->userTypeService->getUserType($parameters['user_type_id']);
        $createdUser = $this->userService->createUser($parameters, $user->getAgent(), $userType);
        $password    = $this->randomPassword();
        $subject     = 'Invitation to create an account';

        $message = Swift_Message::newInstance()
                                ->setSubject($subject)
                                ->setFrom([self::EMAIL_FROM_EMAIL => self::EMAIL_FROM_NAME])
                                ->setTo($createdUser->getEmail())
                                ->setBody(
                                    $this->renderView(
                                        'AuthenticationBundle:Emails:Registration.html.twig',
                                        [
                                            'name'     => $parameters['first_name'],
                                            'password' => $password,
                                        ]
                                    ),
                                    'text/html'
                                )
                                ->addPart(
                                    $this->renderView(
                                        'AuthenticationBundle:Emails:Registration.txt.twig',
                                        [
                                            'name'     => $parameters['first_name'],
                                            'password' => $password,
                                        ]
                                    ),
                                    'text/plain'
                                );

        if ($this->get('mailer')->send($message)) {
            $this->mailService->createMail($user, $user->getAgent(), $createdUser->getEmail(), $subject);
        }

        $createdUser->setPassword(md5($password));
        $this->userService->updateUser($createdUser);

        return Mapper::fromUser($createdUser);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function updateUser(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters) || empty($parameters['id'])) {
            throw new InvalidArgumentException("Identifier not provided");
        }

        $id   = (int)$parameters['id'];
        $user = $this->userService->getUser($userId);

        $updateUser = $this->userService->getUser($id);

        if ($updateUser->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        if (array_key_exists('first_name', $parameters) && $parameters['first_name'] !== null) {
            $updateUser->setFirstName(ucfirst($parameters['first_name']));
        }

        if (array_key_exists('last_name', $parameters) && $parameters['last_name'] !== null) {
            $updateUser->setLastName(ucfirst($parameters['last_name']));
        }

        if (array_key_exists('street', $parameters) && $parameters['street'] !== null) {
            $updateUser->setStreet(ucwords($parameters['street']));
        }

        if (array_key_exists('house_number', $parameters) && $parameters['house_number'] !== null) {
            $updateUser->setHouseNumber($parameters['house_number']);
        }

        if (array_key_exists('postcode', $parameters) && $parameters['postcode'] !== null) {
            $updateUser->setPostcode($parameters['postcode']);
        }

        if (array_key_exists('city', $parameters) && $parameters['city'] !== null) {
            $updateUser->setCity(ucwords($parameters['city']));
        }

        if (array_key_exists('country', $parameters) && $parameters['country'] !== null) {
            $updateUser->setCountry($parameters['country']);
        }

        if (array_key_exists('active', $parameters) && $parameters['active'] !== null) {
            $updateUser->setActive((bool)$parameters['active']);
        }

        if (array_key_exists('phone', $parameters) && $parameters['phone'] !== null) {
            $updateUser->setPhone((string)$parameters['phone']);
        }

        if (array_key_exists('avatar', $parameters) && $parameters['avatar'] !== null) {
            $updateUser->setAvatar((string)$parameters['avatar']);
        }


        return Mapper::fromUser($this->userService->updateUser($updateUser));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function setPassword(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }
        if (!array_key_exists('password', $parameters) && $parameters['password'] !== null) {
            throw new InvalidArgumentException("password parameter not provided");
        }

        $id         = (int)$parameters['id'];
        $user       = $this->userService->getUser($userId);
        $updateUser = $this->userService->getUser($id);

        if ($updateUser->getId() !== $user->getId()) {
            throw new NotAuthorizedException($userId);
        }

        $updateUser->setPassword(md5((string)$parameters['password']));

        $this->userService->updateUser($updateUser);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function disableUser(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id         = (int)$parameters['id'];
        $user       = $this->userService->getUser($userId);
        $updateUser = $this->userService->getUser($id);

        if ($updateUser->getAgent()->getId() !== $user->getAgent()->getId()) {
            throw new NotAuthorizedException($userId);
        }

        $this->userService->disableUser($id);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function deleteUser(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id   = (int)$parameters['id'];
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() >= self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        $this->userService->deleteUser($id);
    }

    /**
     * @return string
     */
    private function randomPassword()
    {
        $alphabet    = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass        = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 10; $i++) {
            $n      = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }
}
