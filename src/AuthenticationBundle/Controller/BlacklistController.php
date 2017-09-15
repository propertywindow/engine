<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\BlacklistNotFoundException;
use AuthenticationBundle\Service\Blacklist\Mapper;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
class BlacklistController extends BaseController
{
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
            list($id, $userId, $method, $parameters) = $this->prepareRequest($httpRequest);

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

        return $this->createResponse($jsonRpcResponse);
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

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
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

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
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
