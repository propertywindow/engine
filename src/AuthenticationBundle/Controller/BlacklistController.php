<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AgentBundle\Exceptions\AgentNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\BlacklistNotFoundException;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Service\Blacklist\Mapper;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\BlacklistController")
 */
class BlacklistController extends BaseController
{
    /**
     * @Route("/authentication/blacklist" , name="blacklist")
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
     * @throws AgentNotFoundException
     * @throws BlacklistNotFoundException
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
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
     * @throws BlacklistNotFoundException
     * @throws UserNotFoundException
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
            throw new NotAuthorizedException();
        }

        return Mapper::fromBlacklist($blacklist);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     * @throws AgentNotFoundException
     */
    private function getBlacklists(int $userId): array
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        $agent     = $this->agentService->getAgent($user->getAgent()->getId());
        $blacklist = $this->blacklistService->getBlacklists($agent);

        return Mapper::fromBlacklists(...$blacklist);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function createBlacklist(array $parameters)
    {
        if (!array_key_exists('user_id', $parameters)) {
            throw new InvalidArgumentException("No user_id argument provided");
        }
        if (!array_key_exists('ip', $parameters)) {
            throw new InvalidArgumentException("No ip argument provided");
        }

        $user = $this->userService->getUser($parameters['user_id']);

        return Mapper::fromBlacklist($this->blacklistService->createBlacklist($parameters['ip'], $user));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws BlacklistNotFoundException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function removeBlacklist(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No id argument provided");
        }

        if (array_key_exists('id', $parameters)) {
            $this->blacklistService->removeBlacklist($parameters['id']);
        }
    }
}
