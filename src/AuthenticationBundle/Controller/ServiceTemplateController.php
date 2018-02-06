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
            $method          = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($method));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param string $method
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(string $method)
    {
        if (is_callable([$this, $method])) {
            return $this->$method();
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getServiceTemplates(): array
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
     * @return array
     * @throws NotAuthorizedException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getServiceTemplate(): array
    {
        $this->checkParameters([
            'id',
        ], $this->parameters);

        $templateUserType = $this->userTypeService->getUserType((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $template = $this->serviceTemplateService->getServiceTemplate($templateUserType);

        return Mapper::fromServiceTemplates(...$template);
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getServiceGroupTemplate(): array
    {
        $this->checkParameters([
            'id',
        ], $this->parameters);

        $templateUserType = $this->userTypeService->getUserType((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $templateGroup = $this->serviceTemplateService->getServiceGroupTemplate($templateUserType);

        return Mapper::fromServiceGroupTemplates(...$templateGroup);
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws ServiceNotFoundException
     * @throws TemplateAlreadyHasServiceException
     * @throws UserTypeNotFoundException
     */
    private function addToServiceTemplate(): array
    {
        $this->checkParameters([
            'user_type_id',
            'service_id',
        ], $this->parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType = $this->userTypeService->getUserType((int)$this->parameters['user_type_id']);
        $service  = $this->serviceService->getService((int)$this->parameters['service_id']);

        return Mapper::fromServiceTemplate($this->serviceTemplateService->addToServiceTemplate($userType, $service));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws ServiceGroupNotFoundException
     * @throws TemplateAlreadyHasServiceException
     * @throws UserTypeNotFoundException
     */
    private function addToServiceGroupTemplate(): array
    {
        $this->checkParameters([
            'user_type_id',
            'service_group_id',
        ], $this->parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType     = $this->userTypeService->getUserType((int)$this->parameters['user_type_id']);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$this->parameters['service_group_id']);

        return Mapper::fromServiceGroupTemplate(
            $this->serviceTemplateService->addToServiceGroupTemplate($userType, $serviceGroup)
        );
    }

    /**
     * @throws NotAuthorizedException
     * @throws ServiceNotFoundException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function removeFromServiceTemplate()
    {
        $this->checkParameters([
            'user_type_id',
            'service_id',
        ], $this->parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType = $this->userTypeService->getUserType((int)$this->parameters['user_type_id']);
        $service  = $this->serviceService->getService((int)$this->parameters['service_id']);

        $this->serviceTemplateService->removeFromServiceTemplate($userType, $service);
    }

    /**
     * @throws NotAuthorizedException
     * @throws ServiceGroupNotFoundException
     * @throws TemplateNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function removeFromServiceGroupTemplate()
    {
        $this->checkParameters([
            'user_type_id',
            'service_group_id',
        ], $this->parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $userType     = $this->userTypeService->getUserType((int)$this->parameters['user_type_id']);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$this->parameters['service_group_id']);

        $this->serviceTemplateService->removeFromServiceGroupTemplate($userType, $serviceGroup);
    }
}
