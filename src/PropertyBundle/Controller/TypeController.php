<?php
declare(strict_types=1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use InvalidArgumentException;
use PropertyBundle\Exceptions\TypeDeleteException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use PropertyBundle\Service\Type\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="PropertyBundle\Controller\TypeController")
 */
class TypeController extends BaseController
{
    /**
     * @Route("/property/type" , name="type")
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
     * @throws TypeDeleteException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getType":
                return $this->getType($parameters);
            case "getTypes":
                return $this->getTypes();
            case "deleteType":
                return $this->deleteType($parameters, $userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    private function getType(array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromType($this->typeService->getType($id));
    }

    /**
     * @return array
     */
    private function getTypes()
    {
        return Mapper::fromTypes(...$this->typeService->getTypes());
    }

    /**
     * @param array $parameters
     * @param int   $userId
     *
     * @throws NotAuthorizedException
     * @throws TypeDeleteException
     */
    private function deleteType(array $parameters, int $userId)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $id = (int)$parameters['id'];

        $this->typeService->deleteType($id);
    }
}
