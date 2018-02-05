<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use AuthenticationBundle\Exceptions\TemplateAlreadyHasServiceException;
use AuthenticationBundle\Exceptions\TemplateNotFoundException;
use AuthenticationBundle\Exceptions\UserTypeNotFoundException;
use AuthenticationBundle\Service\ServiceTemplate\Mapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\ServiceTemplateController")
 */
class ServiceTemplateController extends BaseController
{
    /**
     * @Route("/services/template" , name="service_template")
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
     * @return array
     * @throws NotAuthorizedException
     */
    private function getServiceTemplates()
    {
        $template  = [];
        $userTypes = $this->userTypeService->getUserTypes(true);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        foreach ($userTypes as $userType) {
            switch ($this->user->getSettings()->getLanguage()) {
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
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getServiceTemplate(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $templateUserType = $this->userTypeService->getUserType((int)$parameters['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $template = $this->serviceTemplateService->getServiceTemplate($templateUserType);

        return Mapper::fromServiceTemplates(...$template);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getServiceGroupTemplate(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $templateUserType = $this->userTypeService->getUserType((int)$parameters['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $templateGroup = $this->serviceTemplateService->getServiceGroupTemplate($templateUserType);

        return Mapper::fromServiceGroupTemplates(...$templateGroup);
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws ServiceNotFoundException
     * @throws TemplateAlreadyHasServiceException
     * @throws UserTypeNotFoundException
     */
    private function addToServiceTemplate(array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $service  = $this->serviceService->getService((int)$parameters['service_id']);

        return Mapper::fromServiceTemplate($this->serviceTemplateService->addToServiceTemplate($userType, $service));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws ServiceGroupNotFoundException
     * @throws TemplateAlreadyHasServiceException
     * @throws UserTypeNotFoundException
     */
    private function addToServiceGroupTemplate(array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_group_id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType     = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$parameters['service_group_id']);

        return Mapper::fromServiceGroupTemplate(
            $this->serviceTemplateService->addToServiceGroupTemplate($userType, $serviceGroup)
        );
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws ServiceNotFoundException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function removeFromServiceTemplate(array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $service  = $this->serviceService->getService((int)$parameters['service_id']);

        $this->serviceTemplateService->removeFromServiceTemplate($userType, $service);
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws ServiceGroupNotFoundException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function removeFromServiceGroupTemplate(array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_group_id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType     = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$parameters['service_group_id']);

        $this->serviceTemplateService->removeFromServiceGroupTemplate($userType, $serviceGroup);
    }
}
