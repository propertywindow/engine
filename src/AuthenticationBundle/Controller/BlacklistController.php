<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AgentBundle\Service\AgentService;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\BlacklistNotFoundException;
use AuthenticationBundle\Service\Blacklist\Mapper;
use AuthenticationBundle\Service\BlacklistService;
use AuthenticationBundle\Service\UserService;
use Exception;
use InvalidArgumentException;
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
 * @Route(service="blacklist_controller")
 */
class BlacklistController extends Controller
{
    private const         PARSE_ERROR            = -32700;
    private const         INVALID_REQUEST        = -32600;
    private const         METHOD_NOT_FOUND       = -32601;
    private const         INVALID_PARAMS         = -32602;
    private const         INTERNAL_ERROR         = -32603;
    private const         USER_NOT_AUTHENTICATED = -32000;
    private const         BLACKLIST_NOT_FOUND    = -32001;
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
     * @param Authenticator    $authenticator
     * @param BlacklistService $blacklistService
     * @param UserService      $userService
     * @param AgentService     $agentService
     */
    public function __construct(
        Authenticator $authenticator,
        BlacklistService $blacklistService,
        UserService $userService,
        AgentService $agentService
    ) {
        $this->authenticator    = $authenticator;
        $this->blacklistService = $blacklistService;
        $this->userService      = $userService;
        $this->agentService     = $agentService;
    }

    /**
     * @Route("/authentication/blacklist" , name="blacklist")
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
        } catch (BlacklistNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::BLACKLIST_NOT_FOUND, $ex->getMessage()));
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
     * @throws BlacklistNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getBlacklist":
                return $this->getBlacklist($userId, $parameters);
            case "getBlacklists":
                return $this->getBlacklists($userId);
            case "createBlacklist":
                return $this->createBlacklist($parameters);
            case "removeBlacklist":
                return $this->removeBlacklist($userId, $parameters);
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
    private function getBlacklist(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id        = (int)$parameters['id'];
        $user      = $this->userService->getUser($userId);
        $blacklist = $this->blacklistService->getBlacklist($id);

        if ($user->getAgent()->getId() !== $blacklist->getAgent()->getId() ||
            (int)$user->getUserType()->getId() !== self::USER_ADMIN
        ) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromBlacklist($blacklist);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getBlacklists(int $userId)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() >= self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        $agent     = $this->agentService->getAgent($user->getAgent()->getId());
        $blacklist = $this->blacklistService->getBlacklists($agent);

        return Mapper::fromBlacklists(...$blacklist);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function createBlacklist(array $parameters)
    {
        if (!array_key_exists('user_id', $parameters)) {
            throw new InvalidArgumentException("No user_id argument provided");
        }
        if (!array_key_exists('agent_id', $parameters)) {
            throw new InvalidArgumentException("No agent_id argument provided");
        }
        if (!array_key_exists('ip', $parameters)) {
            throw new InvalidArgumentException("No ip argument provided");
        }

        $user  = $this->userService->getUser($parameters['user_id']);
        $agent = $this->agentService->getAgent($parameters['agent_id']);

        return Mapper::fromBlacklist($this->blacklistService->createBlacklist($parameters['ip'], $user, $agent));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function removeBlacklist(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() >= self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No id argument provided");
        }

        if (array_key_exists('id', $parameters)) {
            $this->blacklistService->removeBlacklist($parameters['id']);
        }
    }
}
