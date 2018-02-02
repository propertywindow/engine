<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Client;
use AgentBundle\Exceptions\ClientNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Exceptions\UserTypeNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Service\Client\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AgentBundle\Controller\ClientController")
 */
class ClientController extends BaseController
{
    /**
     * @Route("/contacts/client" , name="client")
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
     * @throws ClientNotFoundException
     * @throws InvalidJsonRpcMethodException
     * @throws UserAlreadyExistException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
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
     * @throws ClientNotFoundException
     */
    private function getClient(array $parameters): array
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        return Mapper::fromClient($this->clientService->getClient((int)$parameters['id']));
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function getClients(int $userId): array
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromClients(...$this->clientService->getClients($user->getAgent()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     * @throws UserAlreadyExistException
     * @throws UserNotFoundException
     * @throws UserTypeNotFoundException
     */
    private function createClient(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        $this->checkParameters([
            'email',
            'first_name',
            'last_name',
            'street',
            'house_number',
            'postcode',
            'city',
            'country',
        ], $parameters);

        if ($this->userService->getUserByEmail($parameters['email'])) {
            throw new UserAlreadyExistException($parameters['email']);
        }

        $newUser = new User();

        $newUser->setEmail(strtolower($parameters['email']));
        $newUser->setFirstName(ucfirst($parameters['first_name']));
        $newUser->setLastName(ucfirst($parameters['last_name']));
        $newUser->setStreet(ucwords($parameters['street']));
        $newUser->setHouseNumber($parameters['house_number']);
        $newUser->setPostcode($parameters['postcode']);
        $newUser->setCity(ucwords($parameters['city']));
        $newUser->setCountry($parameters['country']);
        $newUser->setAgent($user->getAgent());
        $newUser->setUserType($this->userTypeService->getUserType(4));
        $newUser->setActive(false);

        $createdUser = $this->userService->createUser($newUser);

        $client = new Client();

        $client->setAgent($user->getAgent());
        $client->setUser($createdUser);

        if (array_key_exists('transparency', $parameters) && $parameters['transparency'] !== null) {
            $client->setTransparency($parameters['transparency']);
        }

        $this->clientService->createClient($client);

        return Mapper::fromClient($client);
    }
}
