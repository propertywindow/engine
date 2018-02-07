<?php
declare(strict_types=1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Client;
use AgentBundle\Exceptions\ClientNotFoundException;
use AppBundle\Controller\JsonController;
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
class ClientController extends JsonController
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
     * @throws ClientNotFoundException
     */
    private function getClient(): array
    {
        $this->checkParameters(['id']);

        return Mapper::fromClient($this->clientService->getClient((int)$this->parameters['id']));
    }

    /**
     * @return array
     */
    private function getClients(): array
    {
        return Mapper::fromClients(...$this->clientService->getClients($this->user->getAgent()));
    }

    /**
     * @return array $user
     * @throws UserAlreadyExistException
     * @throws UserTypeNotFoundException
     */
    private function createClient(): array
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
        ]);

        if ($this->userService->getUserByEmail($this->parameters['email'])) {
            throw new UserAlreadyExistException($this->parameters['email']);
        }

        $newUser = new User();

        $this->prepareParameters($newUser);

        $newUser->setAgent($this->user->getAgent());
        $newUser->setUserType($this->userTypeService->getUserType(4));
        $newUser->setActive(false);

        $createdUser = $this->userService->createUser($newUser);

        $client = new Client();

        $client->setAgent($this->user->getAgent());
        $client->setUser($createdUser);

        $this->prepareParameters($client);

        $this->clientService->createClient($client);

        return Mapper::fromClient($client);
    }
}
