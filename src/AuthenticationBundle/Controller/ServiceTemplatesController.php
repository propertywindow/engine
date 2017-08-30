<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Exceptions\TemplateNotFoundException;
use AuthenticationBundle\Service\ServiceTemplatesService;
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
 * @Route(service="service_templates_controller")
 */
class ServiceTemplatesController extends Controller
{
    private const PARSE_ERROR            = -32700;
    private const INVALID_REQUEST        = -32600;
    private const METHOD_NOT_FOUND       = -32601;
    private const INVALID_PARAMS         = -32602;
    private const INTERNAL_ERROR         = -32603;
    private const USER_NOT_AUTHENTICATED = -32000;
    private const TEMPLATE_NOT_FOUND     = -32001;

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var ServiceTemplatesService
     */
    private $serviceTemplatesService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param Authenticator           $authenticator
     * @param ServiceTemplatesService $serviceTemplatesService
     * @param UserService             $userService
     */
    public function __construct(
        Authenticator $authenticator,
        ServiceTemplatesService $serviceTemplatesService,
        UserService $userService
    ) {
        $this->authenticator           = $authenticator;
        $this->serviceTemplatesService = $serviceTemplatesService;
        $this->userService             = $userService;
    }

    /**
     * @Route("/services/templates" , name="service_templates")
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
        } catch (TemplateNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::TEMPLATE_NOT_FOUND, $ex->getMessage()));
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
     * @throws TemplateNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getTemplate":
                return $this->getTemplate($parameters);
            case "getTemplates":
                return $this->getTemplates($parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws TemplateNotFoundException
     */
    private function getTemplate(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromType($this->serviceTemplatesService->getTemplate($id));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function getTemplates(array $parameters)
    {
        return Mapper::fromTypes(...$this->serviceTemplatesService->getTemplates());
    }
}
