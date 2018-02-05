<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Client;
use AgentBundle\Exceptions\ClientNotFoundException;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\UserAlreadyExistException;
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
     * @return array
     */
    private function getClients(): array
    {
        return Mapper::fromClients(...$this->clientService->getClients($this->user->getAgent()));
    }

    /**
     * @param array $parameters
     *
     * @return array $user
     * @throws UserAlreadyExistException
     * @throws UserTypeNotFoundException
     */
    private function createClient(array $parameters)
    {
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
        $newUser->setAgent($this->user->getAgent());
        $newUser->setUserType($this->userTypeService->getUserType(4));
        $newUser->setActive(false);

        $createdUser = $this->userService->createUser($newUser);

        $client = new Client();

        $client->setAgent($this->user->getAgent());
        $client->setUser($createdUser);

        if (array_key_exists('transparency', $parameters) && $parameters['transparency'] !== null) {
            $client->setTransparency($parameters['transparency']);
        }

        $this->clientService->createClient($client);

        return Mapper::fromClient($client);
    }
}
