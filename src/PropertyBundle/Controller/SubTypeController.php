<?php declare(strict_types=1);

namespace PropertyBundle\Controller;

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
use PropertyBundle\Exceptions\SubTypeNotFoundException;
use PropertyBundle\Service\SubTypeService;
use PropertyBundle\Service\SubType\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="sub_type_controller")
 */
class SubTypeController extends Controller
{
    private const PARSE_ERROR            = -32700;
    private const INVALID_REQUEST        = -32600;
    private const METHOD_NOT_FOUND       = -32601;
    private const INVALID_PARAMS         = -32602;
    private const INTERNAL_ERROR         = -32603;
    private const USER_NOT_AUTHENTICATED = -32000;
    private const SUB_TYPE_NOT_FOUND     = -32001;

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var SubTypeService
     */
    private $service;

    /**
     * @param Authenticator  $authenticator
     * @param SubTypeService $service
     */
    public function __construct(Authenticator $authenticator, SubTypeService $service)
    {
        $this->authenticator = $authenticator;
        $this->service       = $service;
    }

    /**
     * @Route("/property/subtype" , name="subtype")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     * @throws \Doctrine\ORM\RuntimeException
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
        } catch (SubTypeNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::SUB_TYPE_NOT_FOUND, $ex->getMessage()));
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
     * @throws SubTypeNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\RuntimeException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getSubType":
                return $this->getSubType($parameters);
            case "getSubTypes":
                return $this->getSubTypes($parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws SubTypeNotFoundException
     */
    private function getSubType(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromSubType($this->service->getSubType($id));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\RuntimeException
     */
    private function getSubTypes(array $parameters)
    {
        $typeId = null;

        if (array_key_exists('typeId', $parameters)) {
            $typeId = (int)$parameters['typeId'];
        }

        return Mapper::fromSubTypes(...$this->service->getSubTypes($typeId));
    }
}
