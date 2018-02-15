<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\Entity\ContactAddress;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use AppBundle\Exceptions\SettingsNotFoundException;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Exception;
use Throwable;

/**
 * @Route(service="AppBundle\Controller\JsonController")
 */
class JsonController extends BaseController
{
    public const PARSE_ERROR            = -32700;
    public const INVALID_REQUEST        = -32600;
    public const METHOD_NOT_FOUND       = -32601;
    public const INVALID_PARAMS         = -32602;
    public const INTERNAL_ERROR         = -32603;
    public const EXCEPTION_ERROR        = -32604;
    public const USER_NOT_AUTHENTICATED = -32000;
    public const USER_ADMIN             = 1;
    public const USER_AGENT             = 2;
    public const USER_COLLEAGUE         = 3;
    public const USER_CLIENT            = 4;
    public const USER_API               = 5;

    /**
     * @var User $user
     */
    public $user;

    /**
     * @var array $parameters
     */
    public $parameters = [];

    /**
     * @return string
     */
    public function randomPassword()
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

    /**
     * @param Request $httpRequest
     * @param bool    $authenticate
     * @param bool    $impersonate
     *
     * @return string
     * @throws CouldNotAuthenticateUserException
     * @throws CouldNotParseJsonRequestException
     * @throws InvalidJsonRpcMethodException
     * @throws InvalidJsonRpcRequestException
     * @throws SettingsNotFoundException
     * @throws UserNotFoundException
     */
    public function prepareRequest(Request $httpRequest, bool $authenticate = true, bool $impersonate = false)
    {
        if ($authenticate) {
            $userId     = $this->authenticator->authenticate($httpRequest, $impersonate);
            $user       = $this->userService->getUser($userId);
            $this->user = $user;
        }

        $ipAddress = $httpRequest->getClientIp();
        $blacklist = $this->blacklistService->checkBlacklist($ipAddress);
        $settings  = $this->settingsService->getSettings();

        if ($blacklist && $blacklist->getAmount() >= $settings->getMaxFailedLogin()) {
            throw new CouldNotAuthenticateUserException("You're IP address ($ipAddress) has been blocked");
        }

        $jsonString = file_get_contents('php://input');
        $jsonArray  = json_decode($jsonString, true);

        $this->checkJsonArray($jsonArray);

        if (array_key_exists('params', $jsonArray)) {
            $this->parameters = $jsonArray['params'];
        }

        return $jsonArray['method'];
    }

    /**
     * @param Response $jsonRpcResponse
     *
     * @return HttpResponse
     */
    public function createResponse(Response $jsonRpcResponse)
    {
        $httpResponse = HttpResponse::create(
            json_encode($jsonRpcResponse),
            200,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $responseHeaders = $httpResponse->headers;

        $responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept, authorization');
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        if ($this->container->get('kernel')->getEnvironment() !== 'dev') {
            $responseHeaders->set('Access-Control-Allow-Origin', '*');
        }

        return $httpResponse;
    }

    /**
     * @param Throwable $throwable
     * @param Request   $httpRequest
     *
     * @return Response
     * @throws Throwable
     */
    public function throwable(Throwable $throwable, Request $httpRequest)
    {
        switch (true) {
            case $throwable instanceof CouldNotParseJsonRequestException:
                $code = self::PARSE_ERROR;
                break;
            case $throwable instanceof InvalidJsonRpcRequestException:
                $code = self::INVALID_REQUEST;
                break;
            case $throwable instanceof InvalidJsonRpcMethodException:
                $code = self::METHOD_NOT_FOUND;
                break;
            case $throwable instanceof InvalidArgumentException:
                $code = self::INVALID_PARAMS;
                break;
            case $throwable instanceof CouldNotAuthenticateUserException:
                $code = self::USER_NOT_AUTHENTICATED;
                break;
            case $throwable instanceof Exception:
                $code   = self::EXCEPTION_ERROR;
                $method = $this->prepareRequest($httpRequest);

                $this->logErrorService->createError(
                    $this->user,
                    $method,
                    $throwable->getMessage(),
                    $this->parameters
                );
                break;
            default:
                $code = self::INTERNAL_ERROR;
        }

        $this->slackService->critical($throwable->getMessage());

        return Response::failure(new Error($code, $throwable->getMessage()));
    }

    /**
     * @param int $userRight
     * @param int $userCheck
     *
     * @throws NotAuthorizedException
     */
    public function isAuthorized(int $userRight, int $userCheck)
    {
        if ($userRight !== $userCheck) {
            throw new NotAuthorizedException();
        }
    }

    /**
     * @param int $userType
     *
     * @throws NotAuthorizedException
     */
    public function hasAccessLevel(int $userType)
    {
        if ($this->user->getUserType()->getId() < $userType) {
            throw new NotAuthorizedException();
        }
    }

    /**
     * @param string[] $required
     */
    public function checkParameters(array $required)
    {
        // todo: add which parameter is missing
        if (count(array_intersect_key(array_flip($required), $this->parameters)) !== count($required)) {
            throw new InvalidArgumentException("there is a required parameter missing");
        }

        if (array_key_exists('email', $required)) {
            if (!filter_var($this->parameters['email'], FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("email parameter not valid");
            }
        }
    }

    /**
     * @param $entity
     */
    public function prepareParameters($entity)
    {
        // todo: add array parameter for which parameters are allowed
        foreach ($this->parameters as $property => $value) {
            $value        = $this->convertParameters($property, $value);
            $propertyPart = explode('_', $property);
            $property     = implode('', array_map('ucfirst', $propertyPart));
            $method       = sprintf('set%s', $property);

            if (is_callable([$entity, $method])) {
                $entity->$method($value);
            }
        }
    }

    /**
     * @return ContactAddress
     */
    public function createAddress()
    {
        $address = new ContactAddress();

        $this->prepareParameters($address);

        return $this->addressService->createAddress($address);
    }

    /**
     * @param string $property
     * @param        $value
     *
     * @return mixed $value
     */
    public function convertParameters(string $property, $value)
    {
        switch ($property) {
            case "office":
            case "name":
            case "first_name":
            case "last_name":
                $value = ucfirst($value);
                break;
            case "email":
                $value = strtolower($value);
                break;
            case "street":
            case "city":
                $value = ucwords($value);
                break;
            case "start":
            case "end":
                $value = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                break;
        }

        return $value;
    }

    /**
     * @param array|null $jsonArray
     *
     * @throws CouldNotParseJsonRequestException
     * @throws InvalidJsonRpcMethodException
     * @throws InvalidJsonRpcRequestException
     */
    private function checkJsonArray(?array $jsonArray)
    {
        if ($jsonArray === null) {
            throw new CouldNotParseJsonRequestException("Could not parse JSON-RPC request");
        }

        if ($jsonArray['jsonrpc'] !== '2.0') {
            throw new InvalidJsonRpcRequestException("Request does not match JSON-RPC 2.0 specification");
        }

        if (empty($jsonArray['method'])) {
            throw new InvalidJsonRpcMethodException("No request method found");
        }
    }
}
