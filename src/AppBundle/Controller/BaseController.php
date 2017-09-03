<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AgentBundle\Service\AgentService;
use AgentBundle\Service\ClientService;
use AppBundle\Security\Authenticator;
use AuthenticationBundle\Service\BlacklistService;
use AuthenticationBundle\Service\ServiceService;
use AuthenticationBundle\Service\ServiceTemplateService;
use AuthenticationBundle\Service\UserService;
use AuthenticationBundle\Service\UserTypeService;
use LogBundle\Service\ActivityService;
use LogBundle\Service\MailService;
use LogBundle\Service\TrafficService;
use PropertyBundle\Service\KindService;
use PropertyBundle\Service\PropertyService;
use PropertyBundle\Service\SubTypeService;
use PropertyBundle\Service\TermsService;
use PropertyBundle\Service\TypeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
    public const          USER_ADMIN             = 1;
    public const          USER_AGENT             = 2;
    public const          USER_COLLEAGUE         = 3;
    public const          USER_CLIENT            = 4;
    public const          USER_API               = 5;
    public const          EMAIL_FROM_EMAIL       = 'no-reply@propertywindow.nl';
    public const          EMAIL_FROM_NAME        = 'Property Window';

    /**
     * @var Authenticator
     */
    public $authenticator;

    /**
     * @var AgentService
     */
    public $agentService;

    /**
     * @var UserService
     */
    public $userService;

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
     * @var ServiceTemplateService
     */
    public $serviceTemplateService;

    /**
     * @var MailService
     */
    public $mailService;

    /**
     * @var PropertyService
     */
    public $propertyService;

    /**
     * @var ClientService
     */
    public $clientService;

    /**
     * @var ActivityService
     */
    public $activityService;

    /**
     * @var TrafficService
     */
    public $trafficService;

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
     * @param Authenticator          $authenticator
     * @param AgentService           $agentService
     * @param UserService            $userService
     * @param BlacklistService       $blacklistService
     * @param UserTypeService        $userTypeService
     * @param ServiceService         $serviceService
     * @param ServiceTemplateService $serviceTemplateService
     * @param MailService            $mailService
     * @param PropertyService        $propertyService
     * @param ClientService          $clientService
     * @param ActivityService        $activityService
     * @param TrafficService         $trafficService
     * @param KindService            $kindService
     * @param TermsService           $termsService
     * @param TypeService            $typeService
     * @param SubTypeService         $subTypeService
     */
    public function __construct(
        Authenticator $authenticator,
        AgentService $agentService,
        UserService $userService,
        BlacklistService $blacklistService,
        UserTypeService $userTypeService,
        ServiceService $serviceService,
        ServiceTemplateService $serviceTemplateService,
        MailService $mailService,
        PropertyService $propertyService,
        ClientService $clientService,
        ActivityService $activityService,
        TrafficService $trafficService,
        KindService $kindService,
        TermsService $termsService,
        TypeService $typeService,
        SubTypeService $subTypeService
    ) {
        $this->authenticator          = $authenticator;
        $this->agentService           = $agentService;
        $this->userService            = $userService;
        $this->blacklistService       = $blacklistService;
        $this->userTypeService        = $userTypeService;
        $this->serviceService         = $serviceService;
        $this->serviceTemplateService = $serviceTemplateService;
        $this->mailService            = $mailService;
        $this->propertyService        = $propertyService;
        $this->clientService          = $clientService;
        $this->activityService        = $activityService;
        $this->trafficService         = $trafficService;
        $this->kindService            = $kindService;
        $this->termsService           = $termsService;
        $this->typeService            = $typeService;
        $this->subTypeService         = $subTypeService;
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
}
