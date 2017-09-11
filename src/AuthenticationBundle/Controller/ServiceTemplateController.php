<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\TemplateNotFoundException;
use AuthenticationBundle\Service\ServiceTemplate\Mapper;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
class ServiceTemplateController extends BaseController
{
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
            list($id, $userId, $method, $parameters) = $this->prepareRequest($httpRequest);

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

        return $this->createResponse($jsonRpcResponse);
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
     */
    private function getServiceTemplates(int $userId)
    {
        $template  = [];
        $user      = $this->userService->getUser($userId);
        $userTypes = $this->userTypeService->getUserTypes(true);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
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
    private function getServiceTemplate(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id               = (int)$parameters['id'];
        $user             = $this->userService->getUser($userId);
        $templateUserType = $this->userTypeService->getUserType($id);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $template = $this->serviceTemplateService->getServiceTemplate($templateUserType);

        return Mapper::fromServiceTemplates(...$template);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getServiceGroupTemplate(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id               = (int)$parameters['id'];
        $user             = $this->userService->getUser($userId);
        $templateUserType = $this->userTypeService->getUserType($id);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $templateGroup = $this->serviceTemplateService->getServiceGroupTemplate($templateUserType);

        return Mapper::fromServiceGroupTemplates(...$templateGroup);
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

        $user     = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

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
     */
    private function addToServiceGroupTemplate(int $userId, array $parameters)
    {
        if (!array_key_exists('user_type_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if (!array_key_exists('service_group_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user         = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

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
     */
    private function removeFromServiceTemplate(int $userId, array $parameters)
    {
        if (!array_key_exists('user_type_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if (!array_key_exists('service_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user     = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $userType = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $service  = $this->serviceService->getService((int)$parameters['service_id']);

        $this->serviceTemplateService->removeFromServiceTemplate($userType, $service);
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function removeFromServiceGroupTemplate(int $userId, array $parameters)
    {
        if (!array_key_exists('user_type_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        if (!array_key_exists('service_group_id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user         = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $userType     = $this->userTypeService->getUserType((int)$parameters['user_type_id']);
        $serviceGroup = $this->serviceGroupService->getServiceGroup((int)$parameters['service_group_id']);

        $this->serviceTemplateService->removeFromServiceGroupTemplate($userType, $serviceGroup);
    }
}
