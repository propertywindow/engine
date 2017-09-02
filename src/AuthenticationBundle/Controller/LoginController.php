<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AgentBundle\Service\AgentService;
use AuthenticationBundle\Exceptions\LoginFailedException;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Service\BlacklistService;
use AuthenticationBundle\Service\UserService;
use Exception;
use InvalidArgumentException;
use LogBundle\Service\LoginService;
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
 * @Route(service="login_controller")
 */
class LoginController extends Controller
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

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var BlacklistService
     */
    private $blacklistService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var AgentService
     */
    private $agentService;

    /**
     * @var LoginService
     */
    private $loginService;

    /**
     * @param Authenticator    $authenticator
     * @param BlacklistService $blacklistService
     * @param UserService      $userService
     * @param AgentService     $agentService
     * @param LoginService     $loginService
     */
    public function __construct(
        Authenticator $authenticator,
        BlacklistService $blacklistService,
        UserService $userService,
        AgentService $agentService,
        LoginService $loginService
    ) {
        $this->authenticator    = $authenticator;
        $this->blacklistService = $blacklistService;
        $this->userService      = $userService;
        $this->agentService     = $agentService;
        $this->loginService     = $loginService;
    }

    /**
     * @Route("/authentication/login" , name="login")
     *
     * @param Request $request
     *
     * @return HttpResponse
     *
     * @throws CouldNotAuthenticateUserException
     */
    public function requestHandler(Request $request)
    {
        $ipAddress = $request->getClientIp();
        $blacklist = $this->blacklistService->checkBlacklist($ipAddress);

        if ($blacklist && $blacklist->getAmount() >= 5) {
            throw new CouldNotAuthenticateUserException("You're IP address ($ipAddress) has been blocked");
        }

        // todo: move requestHandler to generic place/service and call from here, add all errors there too
        // todo: give them all nice numbers to
        // todo: create baseController and extend controllers for all

        $id = null;
        try {
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

            $jsonRpcResponse = Response::success($id, $this->invoke($method, $ipAddress, $parameters));
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
     * @param string $method
     * @param string $ipAddress
     * @param array  $parameters
     *
     * @return array
     *
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(string $method, string $ipAddress, array $parameters = [])
    {
        switch ($method) {
            case "login":
                return $this->login($parameters, $ipAddress);
            case "checkLogin":
                return $this->checkLogin($parameters);
            case "impersonate":
                return $this->impersonate($parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array  $parameters
     * @param string $ipAddress
     *
     * @return array
     * @throws LoginFailedException
     */
    private function login(array $parameters, string $ipAddress)
    {
        if (!array_key_exists('email', $parameters)) {
            throw new InvalidArgumentException("No email argument provided");
        }
        if (!array_key_exists('password', $parameters)) {
            throw new InvalidArgumentException("No password argument provided");
        }

        $email    = (string)$parameters['email'];
        $password = md5((string)$parameters['password']);
        $user     = $this->userService->login($email, $password);

        if ($user === null) {
            $attemptedAgent = null;
            $attemptedUser  = $this->userService->getUserByEmail($email);

            if ($attemptedUser) {
                $attemptedAgent = $attemptedUser->getAgent();
            }

            $this->blacklistService->createBlacklist($ipAddress, $attemptedUser, $attemptedAgent);

            throw new LoginFailedException($email);
        }

        $blacklist = $this->blacklistService->checkBlacklist($ipAddress);
        if ($blacklist) {
            $this->blacklistService->removeBlacklist($blacklist->getId());
        }

        // todo: add check for firstLogin and allow active to be false?

        $this->loginService->createLogin(
            $user,
            $user->getAgent(),
            $ipAddress
        );

        $timestamp      = time();
        $secret         = $user->getPassword();
        $signature      = hash_hmac("sha1", $timestamp."-".$user->getId(), $secret);
        $payload        = [
            "user"      => $user->getId(),
            "password"  => $secret,
            "timestamp" => $timestamp,
            "signature" => $signature,
        ];
        $payloadJson    = json_encode($payload);
        $payloadEncoded = base64_encode($payloadJson);

        return ['Basic '.$payloadEncoded];
    }

    /**
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function checkLogin(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        // todo: check for userId and needs to update OnlineNow timestamp when successful, will return userId.
        // todo: maybe move outside loginController?
    }

    /**
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function impersonate(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        // todo: check if allowed to impersonate, return new token but keep old user_id
        // todo: login, but not update lastlogin
    }
}
