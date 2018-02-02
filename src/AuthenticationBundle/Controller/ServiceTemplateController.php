<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\ServiceGroupNotFoundException;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use AuthenticationBundle\Exceptions\TemplateAlreadyHasServiceException;
use AuthenticationBundle\Exceptions\TemplateNotFoundException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
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
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param int    $userId
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     * @throws ServiceGroupNotFoundException
     * @throws ServiceNotFoundException
     * @throws TemplateAlreadyHasServiceException
     * @throws TemplateNotFoundException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getServiceTemplates":
                return $this->getServiceTemplates($userId);
            case "getServiceTemplate":
                return $this->getServiceTemplate($userId, $parameters);
            case "getServiceGroupTemplate":
                return $this->getServiceGroupTemplate($userId, $parameters);
            case "addToServiceTemplate":
                return $this->addToServiceTemplate($userId, $parameters);
            case "addToServiceGroupTemplate":
                return $this->addToServiceGroupTemplate($userId, $parameters);
            case "removeFromServiceTemplate":
                return $this->removeFromServiceTemplate($userId, $parameters);
            case "removeFromServiceGroupTemplate":
                return $this->removeFromServiceGroupTemplate($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function getServiceTemplates(int $userId)
    {
        $template  = [];
        $user      = $this->userService->getUser($userId);
        $userTypes = $this->userTypeService->getUserTypes(true);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        foreach ($userTypes as $userType) {
            switch ($user->getSettings()->getLanguage()) {
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
     * @throws TemplateNotFoundException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getServiceTemplate(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $id               = (int)$parameters['id'];
        $user             = $this->userService->getUser($userId);
        $templateUserType = $this->userTypeService->getUserType($id);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $template = $this->serviceTemplateService->getServiceTemplate($templateUserType);

        return Mapper::fromServiceTemplates(...$template);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws TemplateNotFoundException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function getServiceGroupTemplate(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user             = $this->userService->getUser($userId);
        $templateUserType = $this->userTypeService->getUserType((int)$parameters['id']);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $templateGroup = $this->serviceTemplateService->getServiceGroupTemplate($templateUserType);

        return Mapper::fromServiceGroupTemplates(...$templateGroup);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws ServiceNotFoundException
     * @throws TemplateAlreadyHasServiceException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function addToServiceTemplate(int $userId, array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_id',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $userType = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $service  = $this->serviceService->getService((int)$parameters['service_id']);

        return Mapper::fromServiceTemplate($this->serviceTemplateService->addToServiceTemplate($userType, $service));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     * @throws ServiceGroupNotFoundException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     * @throws TemplateAlreadyHasServiceException
     */
    private function addToServiceGroupTemplate(int $userId, array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_group_id',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $userType     = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$parameters['service_group_id']);

        return Mapper::fromServiceGroupTemplate(
            $this->serviceTemplateService->addToServiceGroupTemplate($userType, $serviceGroup)
        );
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws TemplateNotFoundException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     * @throws ServiceNotFoundException
     */
    private function removeFromServiceTemplate(int $userId, array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_id',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $userType = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $service  = $this->serviceService->getService((int)$parameters['service_id']);

        $this->serviceTemplateService->removeFromServiceTemplate($userType, $service);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws TemplateNotFoundException
     * @throws ServiceGroupNotFoundException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function removeFromServiceGroupTemplate(int $userId, array $parameters)
    {
        $this->checkParameters([
            'user_type_id',
            'service_group_id',
        ], $parameters);

        $user = $this->userService->getUser($userId);

        $this->isAuthorized($user->getUserType()->getId(), self::USER_ADMIN);

        $userType     = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$parameters['service_group_id']);

        $this->serviceTemplateService->removeFromServiceGroupTemplate($userType, $serviceGroup);
    }
}
