<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AgentBundle\Service\AgentService;
use AgentBundle\Service\AgentGroupService;
use AgentBundle\Service\AgentSettingsService;
use AgentBundle\Service\ClientService;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Security\Authenticator;
use AppBundle\Service\SettingsService;
use AuthenticationBundle\Service\BlacklistService;
use AuthenticationBundle\Service\ServiceMapService;
use AuthenticationBundle\Service\ServiceService;
use AuthenticationBundle\Service\ServiceGroupService;
use AuthenticationBundle\Service\ServiceTemplateService;
use AuthenticationBundle\Service\UserService;
use AuthenticationBundle\Service\UserSettingsService;
use AuthenticationBundle\Service\UserTypeService;
use ConversationBundle\Service\ConversationService;
use ConversationBundle\Service\MailerService;
use ConversationBundle\Service\MessageService;
use ConversationBundle\Service\NotificationService;
use PropertyBundle\Service\GalleryService;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use LogBundle\Service\LogActivityService;
use LogBundle\Service\LogLoginService;
use LogBundle\Service\LogMailService;
use LogBundle\Service\LogTrafficService;
use PropertyBundle\Service\KindService;
use PropertyBundle\Service\PropertyService;
use PropertyBundle\Service\SubTypeService;
use PropertyBundle\Service\TermsService;
use PropertyBundle\Service\TypeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(service="base_controller")
 */
class BaseController extends Controller
{
    public const          PARSE_ERROR            = -32700;
    public const          INVALID_REQUEST        = -32600;
    public const          METHOD_NOT_FOUND       = -32601;
    public const          INVALID_PARAMS         = -32602;
    public const          INTERNAL_ERROR         = -32603;
    public const          USER_NOT_AUTHENTICATED = -32000;
    public const          AGENT_NOT_FOUND        = -32001;
    public const          USER_NOT_FOUND         = -32002;
    public const          BLACKLIST_NOT_FOUND    = -32003;
    public const          SERVICE_NOT_FOUND      = -32004;
    public const          TEMPLATE_NOT_FOUND     = -32005;
    public const          PROPERTY_NOT_FOUND     = -32006;
    public const          TYPE_NOT_FOUND         = -32007;
    public const          SUB_TYPE_NOT_FOUND     = -32008;
    public const          LOG_NOT_FOUND          = -32009;
    public const          NOTIFICATION_NOT_FOUND = -32010;
    public const          CONVERSATION_NOT_FOUND = -32011;
    public const          INBOX_NOT_FOUND        = -32012;
    public const          SETTINGS_NOT_FOUND     = -32013;
    public const          USER_ADMIN             = 1;
    public const          USER_AGENT             = 2;
    public const          USER_COLLEAGUE         = 3;
    public const          USER_CLIENT            = 4;
    public const          USER_API               = 5;

    /**
     * @var Authenticator
     */
    public $authenticator;

    /**
     * @var SettingsService
     */
    public $settingsService;

    /**
     * @var AgentSettingsService
     */
    public $agentSettingsService;

    /**
     * @var AgentService
     */
    public $agentService;

    /**
     * @var AgentGroupService
     */
    public $agentGroupService;

    /**
     * @var UserService
     */
    public $userService;

    /**
     * @var UserSettingsService
     */
    public $userSettingsService;

    /**
     * @var BlacklistService
     */
    public $blacklistService;

    /**
     * @var UserTypeService
     */
    public $userTypeService;

    /**
     * @var ServiceService
     */
    public $serviceService;

    /**
     * @var ServiceGroupService
     */
    public $serviceGroupService;

    /**
     * @var ServiceTemplateService
     */
    public $serviceTemplateService;

    /**
     * @var ServiceMapService
     */
    public $serviceMapService;

    /**
     * @var LogMailService
     */
    public $logMailService;

    /**
     * @var PropertyService
     */
    public $propertyService;

    /**
     * @var ClientService
     */
    public $clientService;

    /**
     * @var LogActivityService
     */
    public $logActivityService;

    /**
     * @var LogTrafficService
     */
    public $logTrafficService;

    /**
     * @var KindService
     */
    public $kindService;

    /**
     * @var TermsService
     */
    public $termsService;

    /**
     * @var TypeService
     */
    public $typeService;

    /**
     * @var SubTypeService
     */
    public $subTypeService;

    /**
     * @var GalleryService
     */
    public $galleryService;

    /**
     * @var LogLoginService
     */
    public $logLoginService;

    /**
     * @var NotificationService
     */
    public $notificationService;

    /**
     * @var ConversationService
     */
    public $conversationService;

    /**
     * @var MessageService
     */
    public $messageService;

    /**
     * @var MailerService
     */
    public $mailerService;

    /**
     * @param Authenticator          $authenticator
     * @param SettingsService        $settingsService
     * @param AgentSettingsService   $agentSettingsService
     * @param AgentService           $agentService
     * @param AgentGroupService      $agentGroupService
     * @param UserService            $userService
     * @param UserSettingsService    $userSettingsService
     * @param BlacklistService       $blacklistService
     * @param UserTypeService        $userTypeService
     * @param ServiceService         $serviceService
     * @param ServiceGroupService    $serviceGroupService
     * @param ServiceTemplateService $serviceTemplateService
     * @param ServiceMapService      $serviceMapService
     * @param LogMailService         $logMailService
     * @param PropertyService        $propertyService
     * @param ClientService          $clientService
     * @param LogActivityService     $logActivityService
     * @param LogTrafficService      $logTrafficService
     * @param KindService            $kindService
     * @param TermsService           $termsService
     * @param TypeService            $typeService
     * @param SubTypeService         $subTypeService
     * @param GalleryService         $galleryService
     * @param LogLoginService        $logLoginService
     * @param NotificationService    $notificationService
     * @param ConversationService    $conversationService
     * @param MessageService         $messageService
     * @param MailerService          $mailerService
     */
    public function __construct(
        Authenticator $authenticator,
        SettingsService $settingsService,
        AgentSettingsService $agentSettingsService,
        AgentService $agentService,
        AgentGroupService $agentGroupService,
        UserService $userService,
        UserSettingsService $userSettingsService,
        BlacklistService $blacklistService,
        UserTypeService $userTypeService,
        ServiceService $serviceService,
        ServiceGroupService $serviceGroupService,
        ServiceTemplateService $serviceTemplateService,
        ServiceMapService $serviceMapService,
        LogMailService $logMailService,
        PropertyService $propertyService,
        ClientService $clientService,
        LogActivityService $logActivityService,
        LogTrafficService $logTrafficService,
        KindService $kindService,
        TermsService $termsService,
        TypeService $typeService,
        SubTypeService $subTypeService,
        GalleryService $galleryService,
        LogLoginService $logLoginService,
        NotificationService $notificationService,
        ConversationService $conversationService,
        MessageService $messageService,
        MailerService $mailerService
    ) {
        $this->authenticator          = $authenticator;
        $this->settingsService        = $settingsService;
        $this->agentSettingsService   = $agentSettingsService;
        $this->agentService           = $agentService;
        $this->agentGroupService      = $agentGroupService;
        $this->userService            = $userService;
        $this->userSettingsService    = $userSettingsService;
        $this->blacklistService       = $blacklistService;
        $this->userTypeService        = $userTypeService;
        $this->serviceService         = $serviceService;
        $this->serviceGroupService    = $serviceGroupService;
        $this->serviceTemplateService = $serviceTemplateService;
        $this->serviceMapService      = $serviceMapService;
        $this->logMailService         = $logMailService;
        $this->propertyService        = $propertyService;
        $this->clientService          = $clientService;
        $this->logActivityService     = $logActivityService;
        $this->logTrafficService      = $logTrafficService;
        $this->kindService            = $kindService;
        $this->termsService           = $termsService;
        $this->typeService            = $typeService;
        $this->subTypeService         = $subTypeService;
        $this->galleryService         = $galleryService;
        $this->logLoginService        = $logLoginService;
        $this->notificationService    = $notificationService;
        $this->conversationService    = $conversationService;
        $this->messageService         = $messageService;
        $this->mailerService          = $mailerService;
    }

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
     * @return array
     * @throws CouldNotAuthenticateUserException
     * @throws CouldNotParseJsonRequestException
     * @throws InvalidJsonRpcMethodException
     * @throws InvalidJsonRpcRequestException
     */
    public function prepareRequest(Request $httpRequest, bool $authenticate = true, bool $impersonate = false)
    {
        $id     = null;
        $userId = null;

        if ($authenticate) {
            $userId = $this->authenticator->authenticate($httpRequest, $impersonate);
        }

        $ipAddress = $httpRequest->getClientIp();
        $blacklist = $this->blacklistService->checkBlacklist($ipAddress);
        $settings  = $this->settingsService->getSettings();

        if ($blacklist && $blacklist->getAmount() >= $settings->getMaxFailedLogin()) {
            throw new CouldNotAuthenticateUserException("You're IP address ($ipAddress) has been blocked");
        }

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

        if ($authenticate) {
            return [$id, $userId, $method, $parameters];
        } else {
            return [$id, $method, $parameters];
        }
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
        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $httpResponse;
    }
}
