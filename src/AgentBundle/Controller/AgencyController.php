<?php
declare(strict_types = 1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Agency;
use AgentBundle\Exceptions\AgencyNotFoundException;
use AppBundle\Controller\JsonController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Service\Agency\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AgentBundle\Controller\AgencyController")
 */
class AgencyController extends JsonController
{
    /**
     * @Route("/agency" , name="agency")
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
     * @throws AgencyNotFoundException
     * @throws NotAuthorizedException
     */
    private function getAgency()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters(['id']);

        $agency = $this->agencyService->getAgency((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $agency->getAgent()->getId());

        return Mapper::fromAgency($agency);
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getAgencies()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        return Mapper::fromAgencies(...$this->agencyService->getAgencies($this->user->getAgent()));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function createAgency(): array
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters([
            'name',
            'email',
            'street',
            'house_number',
            'postcode',
            'city',
            'country',
        ]);

        $agency = new Agency();

        $agency->setAgent($this->user->getAgent());
        $agency->setAddress($this->createAddress());

        $this->prepareParameters($agency);

        $agency = $this->agencyService->createAgency($agency);

        return Mapper::fromAgency($agency);
    }

    /**
     * @return array
     * @throws AgencyNotFoundException
     * @throws NotAuthorizedException
     */
    private function updateAgency()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters(['id']);

        $agency = $this->agencyService->getAgency((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $agency->getAgent()->getId());

        $agency->setAddress($this->createAddress());

        $this->prepareParameters($agency);

        return Mapper::fromAgency($this->agencyService->updateAgency($agency));
    }

    /**
     * @throws AgencyNotFoundException
     * @throws NotAuthorizedException
     */
    private function deleteAgency()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters(['id']);

        $agency = $this->agencyService->getAgency((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $agency->getAgent()->getId());

        $this->agencyService->deleteAgency($agency);
    }
}
