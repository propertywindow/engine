<?php
declare(strict_types = 1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\JsonController;
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
class SubTypeController extends JsonController
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
     * @throws SubTypeNotFoundException
     */
    private function getSubType()
    {
        $this->checkParameters(['id']);

        return Mapper::fromSubType(
            $this->user->getSettings()->getLanguage(),
            $this->subTypeService->getSubType((int)$this->parameters['id'])
        );
    }

    /**
     * @return array
     */
    private function getSubTypes()
    {
        return Mapper::fromSubTypes(
            $this->user->getSettings()->getLanguage(),
            ...$this->subTypeService->getSubTypes()
        );
    }

    /**
     * @return array
     * @throws TypeNotFoundException
     */
    private function getSubTypesForType()
    {
        $this->checkParameters(['type_id']);

        $type = $this->typeService->getType((int)$this->parameters['type_id']);

        return Mapper::fromSubTypes(
            $this->user->getSettings()->getLanguage(),
            ...$this->subTypeService->getSubTypesForType($type)
        );
    }

    /**
     * @throws NotAuthorizedException
     * @throws SubTypeDeleteException
     * @throws SubTypeNotFoundException
     */
    private function deleteSubType()
    {
        $this->hasAccessLevel(self::USER_ADMIN);

        $this->checkParameters(['id']);

        $this->subTypeService->deleteSubType((int)$this->parameters['id']);
    }
}
