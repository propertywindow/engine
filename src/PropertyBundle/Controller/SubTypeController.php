<?php
declare(strict_types=1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use PropertyBundle\Exceptions\SubTypeDeleteException;
use PropertyBundle\Exceptions\SubTypeNotFoundException;
use PropertyBundle\Exceptions\TypeNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use PropertyBundle\Service\SubType\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="PropertyBundle\Controller\SubTypeController")
 */
class SubTypeController extends BaseController
{
    /**
     * @Route("/property/subtype" , name="subtype")
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
     * @throws SubTypeNotFoundException
     */
    private function getSubType(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        return Mapper::fromSubType($this->subTypeService->getSubType((int)$parameters['id']));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws TypeNotFoundException
     */
    private function getSubTypes(array $parameters)
    {
        $this->checkParameters([
            'type_id',
        ], $parameters);

        $type = $this->typeService->getType((int)$parameters['type_id']);

        return Mapper::fromSubTypes(...$this->subTypeService->getSubTypes($type));
    }

    /**
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     * @throws SubTypeDeleteException
     * @throws SubTypeNotFoundException
     */
    private function deleteSubType(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $this->isAuthorized($this->user->getUserType()->getId(), self::USER_ADMIN);

        $this->subTypeService->deleteSubType((int)$parameters['id']);
    }
}
