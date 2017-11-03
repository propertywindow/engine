<?php declare(strict_types=1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use PropertyBundle\Exceptions\SubTypeNotFoundException;
use PropertyBundle\Service\SubType\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="sub_type_controller")
 */
class SubTypeController extends BaseController
{
    /**
     * @Route("/property/subtype" , name="subtype")
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
     * @throws SubTypeNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getSubType":
                return $this->getSubType($parameters);
            case "getSubTypes":
                return $this->getSubTypes($parameters);
            case "deleteSubType":
                return $this->deleteSubType($parameters, $userId);
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
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id = (int)$parameters['id'];

        return Mapper::fromSubType($this->subTypeService->getSubType($id));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function getSubTypes(array $parameters)
    {
        $typeId = null;

        if (!array_key_exists('type_id', $parameters)) {
            throw new InvalidArgumentException("No type_id argument provided");
        }

        $type = $this->typeService->getType((int)$parameters['type_id']);

        return Mapper::fromSubTypes(...$this->subTypeService->getSubTypes($type));
    }

    /**
     * @param array $parameters
     * @param int   $userId
     *
     * @throws NotAuthorizedException
     */
    private function deleteSubType(array $parameters, int $userId)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $user = $this->userService->getUser($userId);

        if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
            throw new NotAuthorizedException($userId);
        }

        $id = (int)$parameters['id'];

        $this->subTypeService->deleteSubType($id);
    }
}
