<?php
declare(strict_types=1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\JsonController;
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
class TypeController extends JsonController
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
     * @throws TypeNotFoundException
     */
    private function getType(): array
    {
        $this->checkParameters(['id']);

        return Mapper::fromType($this->typeService->getType((int)$this->parameters['id']));
    }

    /**
     * @return array
     */
    private function getTypes(): array
    {
        return Mapper::fromTypes(...$this->typeService->getTypes());
    }

    /**
     * @throws NotAuthorizedException
     * @throws TypeDeleteException
     * @throws TypeNotFoundException
     */
    private function deleteType()
    {
        $this->checkParameters(['id']);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $this->typeService->deleteType((int)$this->parameters['id']);
    }
}
