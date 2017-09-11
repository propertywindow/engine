<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\LoginFailedException;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
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
 * @Route(service="login_controller")
 */
class LoginController extends BaseController
{
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
        $id        = null;
        $ipAddress = $request->getClientIp();
        try {
            list($id, $method, $parameters) = $this->prepareRequest($request, false);

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

        return $this->createResponse($jsonRpcResponse);
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
                return $this->login($ipAddress, $parameters);
            case "impersonate":
                return $this->impersonate($parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param string $ipAddress
     * @param array  $parameters
     *
     * @return array
     *
     * @throws LoginFailedException
     */
    private function login(string $ipAddress, array $parameters)
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

        return [$user->getId(), $payloadEncoded];
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
        if (!array_key_exists('user_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }
        if (!array_key_exists('impersonate_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $userId        = (int)$parameters['user_id'];
        $impersonateId = (int)$parameters['impersonate_id'];
        $user          = $this->userService->getUser($userId);
        $impersonate   = $this->userService->getUser($impersonateId);

        if ((int)$user->getUserType()->getId() >= self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        if ($user->getAgent() !== $impersonate->getAgent()) {
            throw new NotAuthorizedException($userId);
        }

        $timestamp      = time();
        $secret         = $impersonate->getPassword();
        $signature      = hash_hmac("sha1", $timestamp."-".$impersonate->getId(), $secret);
        $payload        = [
            "user"      => $impersonate->getId(),
            "password"  => $secret,
            "timestamp" => $timestamp,
            "signature" => $signature,
        ];
        $payloadJson    = json_encode($payload);
        $payloadEncoded = base64_encode($payloadJson);

        return [$impersonate->getId(), $impersonate->getEmail(), $payloadEncoded];
    }
}
