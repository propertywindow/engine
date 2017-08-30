<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\TemplateNotFoundException;
use AuthenticationBundle\Service\ServiceService;
use AuthenticationBundle\Service\ServiceTemplate\Mapper;
use AuthenticationBundle\Service\ServiceTemplateService;
use AuthenticationBundle\Service\UserService;
use AuthenticationBundle\Service\UserTypeService;
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
 * @Route(service="service_template_controller")
 */
class ServiceTemplateController extends Controller
{
    private const         PARSE_ERROR            = -32700;
    private const         INVALID_REQUEST        = -32600;
    private const         METHOD_NOT_FOUND       = -32601;
    private const         INVALID_PARAMS         = -32602;
    private const         INTERNAL_ERROR         = -32603;
    private const         USER_NOT_AUTHENTICATED = -32000;
    private const         TEMPLATE_NOT_FOUND     = -32001;
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
     * @var ServiceService
     */
    private $serviceService;

    /**
     * @var ServiceTemplateService
     */
    private $serviceTemplateService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserTypeService
     */
    private $userTypeService;

    /**
     * @param Authenticator          $authenticator
     * @param ServiceService         $serviceService
     * @param ServiceTemplateService $serviceTemplateService
     * @param UserService            $userService
     * @param UserTypeService        $userTypeService
     */
    public function __construct(
        Authenticator $authenticator,
        ServiceService $serviceService,
        ServiceTemplateService $serviceTemplateService,
        UserService $userService,
        UserTypeService $userTypeService
    ) {
        $this->authenticator          = $authenticator;
        $this->serviceService         = $serviceService;
        $this->serviceTemplateService = $serviceTemplateService;
        $this->userService            = $userService;
        $this->userTypeService        = $userTypeService;
    }

    /**
     * @Route("/services/template" , name="service_template")
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
            case "getServiceTemplate":
                return $this->getServiceTemplate($userId, $parameters);
            case "getServiceTemplates":
                return $this->getServiceTemplates($userId);
            case "addToServiceTemplate":
                return $this->addToServiceTemplate($userId, $parameters);
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
    private function getServiceTemplate(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id               = (int)$parameters['id'];
        $user             = $this->userService->getUser($userId);
        $templateUserType = $this->userTypeService->getUserType($id);

        if ((int)$user->getTypeId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $template = $this->serviceTemplateService->getServiceTemplate($templateUserType);

        return Mapper::fromServiceTemplates(...$template);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getServiceTemplates(int $userId)
    {
        $template  = [];
        $user      = $this->userService->getUser($userId);
        $userTypes = $this->userTypeService->getUserTypes();

        if ((int)$user->getTypeId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }
        foreach ($userTypes as $userType) {
            switch ($user->getLanguage()) {
                case "nl":
                    $description = $userType->getNl();
                    break;
                case "en":
                    $description = $userType->getEn();
                    break;
                default:
                    $description = $userType->getEn();
            }

            $template[] = [
                'id'          => $userType->getId(),
                'description' => $description,
            ];
        }

        return $template;
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function addToServiceTemplate(int $userId, array $parameters)
    {
        if (!array_key_exists('user_type_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if (!array_key_exists('service_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user       = $this->userService->getUser($userId);
        $userType   = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $service    = $this->serviceService->getService((int)$parameters['service_id']);

        if ((int)$user->getTypeId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $template = $this->serviceTemplateService->addToServiceTemplate($userType, $service);

        return Mapper::fromServiceTemplate($template);
    }
}
