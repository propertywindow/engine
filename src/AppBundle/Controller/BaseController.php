<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use AgentBundle\Service\AgencyService;
use AgentBundle\Service\AgentService;
use AgentBundle\Service\AgentGroupService;
use AgentBundle\Service\AgentSettingsService;
use AgentBundle\Service\SolicitorService;
use AppBundle\Exceptions\SettingsNotFoundException;
use AppBundle\Service\ContactAddressService;
use ClientBundle\Service\ClientService;
use AlertBundle\Service\AlertService;
use AlertBundle\Service\ApplicantService;
use AlertBundle\Service\ApplicationService;
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
use LogBundle\Service\LogErrorService;
use LogBundle\Service\SlackService;
use PropertyBundle\Service\GalleryService;
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

/**
 * @Route(service="AppBundle\Controller\BaseController")
 */
class BaseController extends Controller
{
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
     * @var LogErrorService
     */
    public $logErrorService;

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
     * @var SlackService
     */
    public $slackService;

    /**
     * @var AlertService
     */
    public $alertService;

    /**
     * @var ApplicantService
     */
    public $applicantService;

    /**
     * @var ApplicationService
     */
    public $applicationService;

    /**
     * @var SolicitorService
     */
    public $solicitorService;

    /**
     * @var AgencyService
     */
    public $agencyService;

    /**
     * @var ContactAddressService
     */
    public $addressService;

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
     * @param LogErrorService        $logErrorService
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
     * @param SlackService           $slackService
     * @param AlertService           $alertService
     * @param ApplicantService       $applicantService
     * @param ApplicationService     $applicationService
     * @param SolicitorService       $solicitorService
     * @param AgencyService          $agencyService
     * @param ContactAddressService  $addressService
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
        LogErrorService $logErrorService,
        KindService $kindService,
        TermsService $termsService,
        TypeService $typeService,
        SubTypeService $subTypeService,
        GalleryService $galleryService,
        LogLoginService $logLoginService,
        NotificationService $notificationService,
        ConversationService $conversationService,
        MessageService $messageService,
        MailerService $mailerService,
        SlackService $slackService,
        AlertService $alertService,
        ApplicantService $applicantService,
        ApplicationService $applicationService,
        SolicitorService $solicitorService,
        AgencyService $agencyService,
        ContactAddressService $addressService
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
        $this->logErrorService        = $logErrorService;
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
        $this->slackService           = $slackService;
        $this->alertService           = $alertService;
        $this->applicantService       = $applicantService;
        $this->applicationService     = $applicationService;
        $this->solicitorService       = $solicitorService;
        $this->agencyService          = $agencyService;
        $this->addressService         = $addressService;
    }

    /**
     * @param string $postcode
     * @param string $country
     *
     * @return array
     * @throws SettingsNotFoundException
     */
    public function getCoordinatesFromPostcode(string $postcode, string $country): array
    {
        $key    = $this->settingsService->getSettings()->getGoogleKey();
        $url    = 'https://maps.googleapis.com/maps/api/geocode/json?address='
                  . urlencode($postcode)
                  . ','
                  . urlencode($country)
                  . '&sensor=false&key=' . $key;
        $result = file_get_contents($url);
        $json   = json_decode($result);

        return [
            'lat' => $json->results[0]->geometry->location->lat,
            'lng' => $json->results[0]->geometry->location->lng,
        ];
    }

    /**
     * @param      $lat1
     * @param      $lng1
     * @param      $lat2
     * @param      $lng2
     * @param bool $miles
     *
     * @return float|int
     */
    public function getDistance($lat1, $lng1, $lat2, $lng2, $miles = true)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r    = 6372.797;
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a    = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
        $c    = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km   = $r * $c;

        return ($miles ? ($km * 0.621371192) : $km);
    }
}
