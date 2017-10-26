<?php declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Agent;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Service\Agent\Mapper;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="agent_controller")
 */
class AgentController extends BaseController
{
    /**
     * @Route("/agent" , name="agent")
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
        } catch (AgentNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::AGENT_NOT_FOUND, $ex->getMessage()));
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
     * @throws UserNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getAgent":
                return $this->getAgent($parameters);
            case "getAgents":
                return $this->getAgents($userId);
            case "createAgent":
                return $this->createAgent($userId, $parameters);
            case "updateAgent":
                return $this->updateAgent($userId, $parameters);
            case "deleteAgent":
                return $this->deleteAgent($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws AgentNotFoundException
     */
    private function getAgent(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromAgent($this->agentService->getAgent($id));
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getAgents(int $userId)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromAgents(...$this->agentService->getAgents());
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     *
     * @throws NotAuthorizedException
     * @throws UserAlreadyExistException
     */
    private function createAgent(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        if (!array_key_exists('agent_group_id', $parameters)) {
            if (!array_key_exists('name', $parameters) && $parameters['name'] !== null) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }
        if (!array_key_exists('name', $parameters)) {
            if (!array_key_exists('agent_group_id', $parameters) && $parameters['agent_group_id'] !== null) {
                throw new InvalidArgumentException("name or agent_group_id parameter not provided");
            }
        }
        if (!array_key_exists('office', $parameters) && $parameters['office'] !== null) {
            throw new InvalidArgumentException("office parameter not provided");
        }
        if (!array_key_exists('email', $parameters) && $parameters['email'] !== null) {
            throw new InvalidArgumentException("email parameter not provided");
        }
        if (!filter_var($parameters['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("email parameter not valid");
        }
        if (!array_key_exists('first_name', $parameters) && $parameters['first_name'] !== null) {
            throw new InvalidArgumentException("first_name parameter not provided");
        }
        if (!array_key_exists('last_name', $parameters) && $parameters['last_name'] !== null) {
            throw new InvalidArgumentException("last_name parameter not provided");
        }
        if (!array_key_exists('street', $parameters) && $parameters['street'] !== null) {
            throw new InvalidArgumentException("street parameter not provided");
        }
        if (!array_key_exists('house_number', $parameters) && $parameters['house_number'] !== null) {
            throw new InvalidArgumentException("house_number parameter not provided");
        }
        if (!array_key_exists('postcode', $parameters) && $parameters['postcode'] !== null) {
            throw new InvalidArgumentException("postcode parameter not provided");
        }
        if (!array_key_exists('city', $parameters) && $parameters['city'] !== null) {
            throw new InvalidArgumentException("city parameter not provided");
        }
        if (!array_key_exists('country', $parameters) && $parameters['country'] !== null) {
            throw new InvalidArgumentException("country parameter not provided");
        }

        if ($this->userService->getUserByEmail($parameters['email'])) {
            throw new UserAlreadyExistException($parameters['email']);
        }

        $agent      = new Agent();
        $agentGroup = $this->agentGroupService->getAgentGroup($parameters['agent_group_id']);

        $agent->setAgentGroup($agentGroup);
        $agent->setOffice($parameters['office']);
        $agent->setStreet(ucwords($parameters['street']));
        $agent->setHouseNumber($parameters['house_number']);
        $agent->setPostcode($parameters['postcode']);
        $agent->setCity(ucwords($parameters['city']));
        $agent->setCountry($parameters['country']);
        $agent->setEmail($parameters['email']);

        if (array_key_exists('property_limit', $parameters) && $parameters['property_limit'] !== null) {
            $agent->setPropertyLimit((int)$parameters['property_limit']);
        }
        if (array_key_exists('phone', $parameters) && $parameters['phone'] !== null) {
            $agent->setPhone((string)$parameters['phone']);
        }
        if (array_key_exists('fax', $parameters) && $parameters['fax'] !== null) {
            $agent->setFax((string)$parameters['fax']);
        }
        if (array_key_exists('espc', $parameters) && $parameters['espc'] !== null) {
            $agent->setEspc((bool)$parameters['espc']);
        }
        if (array_key_exists('web_print', $parameters) && $parameters['web_print'] !== null) {
            $agent->setWebprint((bool)$parameters['web_print']);
        }
        if (array_key_exists('logo', $parameters) && $parameters['logo'] !== null) {
            $agent->setLogo((string)$parameters['logo']);
        }
        if (array_key_exists('website', $parameters) && $parameters['website'] !== null) {
            $agent->setWebsite((string)$parameters['website']);
        }

        $agent    = $this->agentService->createAgent($agent);
        $userType = $this->userTypeService->getUserType(2);

        // todo: move new User() from userService to here

        $createdUser = $this->userService->createUser($parameters, $agent, $userType);
        $password    = $this->randomPassword();

        $mailParameters = [
            'name'     => $parameters['first_name'],
            'password' => $password,
        ];

        $this->mailerService->sendMail($user, $createdUser->getEmail(), 'user_invite_email', $mailParameters);

        $createdUser->setPassword(md5($password));
        $this->userService->updateUser($createdUser);

        $agent->setUserId($createdUser->getId());
        $this->agentService->updateAgent($agent);

        // todo: also set serviceGroupMap and serviceMap, do this in serviceMapService -> wizard saves during each step
        // todo:  $createdUser->setActive(true); and agent active after services are set.

        return Mapper::fromAgent($agent);
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function updateAgent(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters) || empty($parameters['id'])) {
            throw new InvalidArgumentException("Identifier not provided");
        }

        if (!filter_var($parameters['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("email parameter not valid");
        }

        $id   = (int)$parameters['id'];
        $user = $this->userService->getUser($userId);

        $updateAgent = $this->agentService->getAgent($id);

        if ((int)$user->getUserType()->getId() <= self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        if ($updateAgent->getId() !== $user->getAgent()->getId()) {
            if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
                throw new NotAuthorizedException($userId);
            }
        }

        if (array_key_exists('office', $parameters) && $parameters['office'] !== null) {
            $updateAgent->setOffice(ucfirst($parameters['office']));
        }
        if (array_key_exists('phone', $parameters) && $parameters['phone'] !== null) {
            $updateAgent->setPhone($parameters['phone']);
        }
        if (array_key_exists('fax', $parameters) && $parameters['fax'] !== null) {
            $updateAgent->setFax($parameters['fax']);
        }
        if (array_key_exists('email', $parameters) && $parameters['email'] !== null) {
            $updateAgent->setEmail($parameters['email']);
        }
        if (array_key_exists('website', $parameters) && $parameters['website'] !== null) {
            $updateAgent->setWebsite($parameters['website']);
        }
        if (array_key_exists('logo', $parameters) && $parameters['logo'] !== null) {
            $updateAgent->setLogo($parameters['logo']);
        }
        if (array_key_exists('street', $parameters) && $parameters['street'] !== null) {
            $updateAgent->setStreet($parameters['street']);
        }
        if (array_key_exists('house_number', $parameters) && $parameters['house_number'] !== null) {
            $updateAgent->setHouseNumber($parameters['house_number']);
        }
        if (array_key_exists('postcode', $parameters) && $parameters['postcode'] !== null) {
            $updateAgent->setPostcode($parameters['postcode']);
        }
        if (array_key_exists('city', $parameters) && $parameters['city'] !== null) {
            $updateAgent->setCity($parameters['city']);
        }
        if (array_key_exists('country', $parameters) && $parameters['country'] !== null) {
            $updateAgent->setCountry($parameters['country']);
        }
        if (array_key_exists('property_limit', $parameters) && $parameters['property_limit'] !== null) {
            $updateAgent->setPropertyLimit((int)$parameters['property_limit']);
        }
        if (array_key_exists('web_print', $parameters) && $parameters['web_print'] !== null) {
            $updateAgent->setWebprint((bool)$parameters['web_print']);
        }
        if (array_key_exists('espc', $parameters) && $parameters['espc'] !== null) {
            $updateAgent->setEspc((bool)$parameters['espc']);
        }
        if (array_key_exists('archived', $parameters) && $parameters['archived'] !== null) {
            $updateAgent->setArchived((bool)$parameters['archived']);
        }

        return Mapper::fromAgent($this->agentService->updateAgent($updateAgent));
    }


    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function deleteAgent(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $id = (int)$parameters['id'];

        // todo: check for users and properties before deleting, just warning

        $this->agentService->deleteAgent($id);
    }
}
