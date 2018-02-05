<?php
declare(strict_types=1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use PropertyBundle\Exceptions\TypeDeleteException;
use PropertyBundle\Exceptions\TypeNotFoundException;
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
     * @throws TypeNotFoundException
     */
    private function getType(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        return Mapper::fromType($this->typeService->getType((int)$parameters['id']));
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
     *
     * @throws NotAuthorizedException
     * @throws TypeDeleteException
     * @throws TypeNotFoundException
     */
    private function deleteType(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $this->typeService->deleteType((int)$parameters['id']);
    }
}
