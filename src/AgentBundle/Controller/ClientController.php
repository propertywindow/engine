<?php declare(strict_types=1);

namespace AgentBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Service\Client\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="client_controller")
 */
class ClientController extends BaseController
{
    /**
     * @Route("/contacts/client" , name="client")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     */
    public function requestHandler(Request $httpRequest)
    {
        try {
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable);
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
            case "getClient":
                return $this->getClient($parameters);
            case "getClients":
                return $this->getClients($userId);
            case "createClient":
                return $this->createClient($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws AgentNotFoundException
     */
    private function getClient(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromClient($this->clientService->getClient($id));
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws NotAuthorizedException
     */
    private function getClients(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromClients(...$this->clientService->getClients($user->getAgent()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     *
     * @throws UserAlreadyExistException
     */
    private function createClient(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

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

        $userType    = $this->userTypeService->getUserType(4);
        $createdUser = $this->userService->createUser($parameters, $user->getAgent(), $userType);
        $client      = $this->clientService->createClient($parameters, $createdUser, $user->getAgent());

        return Mapper::fromClient($client);
    }
}
