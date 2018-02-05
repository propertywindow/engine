<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AgentBundle\Exceptions\AgentNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\BlacklistNotFoundException;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Service\Blacklist\Mapper;
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
     * @throws BlacklistNotFoundException
     * @throws NotAuthorizedException
     */
    private function getBlacklist(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $blacklist = $this->blacklistService->getBlacklist((int)$parameters['id']);

        if ($this->user->getAgent()->getId() !== $blacklist->getAgent()->getId() ||
            $this->user->getUserType()->getId() !== self::USER_ADMIN
        ) {
            throw new NotAuthorizedException();
        }

        return Mapper::fromBlacklist($blacklist);
    }

    /**
     * @return array
     * @throws AgentNotFoundException
     * @throws NotAuthorizedException
     */
    private function getBlacklists(): array
    {
        if ($this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        $agent     = $this->agentService->getAgent($this->user->getAgent()->getId());
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
        $this->checkParameters([
            'user_id',
            'ip',
        ], $parameters);

        $user = $this->userService->getUser($parameters['user_id']);

        return Mapper::fromBlacklist($this->blacklistService->createBlacklist($parameters['ip'], $user));
    }

    /**
     * @param array $parameters
     *
     * @throws BlacklistNotFoundException
     * @throws NotAuthorizedException
     */
    private function removeBlacklist(array $parameters)
    {
        if ($this->user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException();
        }

        $this->checkParameters([
            'id',
        ], $parameters);

        if (array_key_exists('id', $parameters)) {
            $this->blacklistService->removeBlacklist($parameters['id']);
        }
    }
}
