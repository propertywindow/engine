<?php
declare(strict_types = 1);

namespace AgentBundle\Controller;

use AgentBundle\Entity\Solicitor;
use AgentBundle\Exceptions\AgencyNotFoundException;
use AgentBundle\Exceptions\SolicitorNotFoundException;
use AppBundle\Controller\JsonController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Service\Solicitor\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AgentBundle\Controller\SolicitorController")
 */
class SolicitorController extends JsonController
{
    /**
     * @Route("/solicitor" , name="solicitor")
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
     * @throws NotAuthorizedException
     * @throws SolicitorNotFoundException
     */
    private function getSolicitor()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters(['id']);

        $solicitor = $this->solicitorService->getSolicitor((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $solicitor->getAgent()->getId());

        return Mapper::fromSolicitor($solicitor);
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     */
    private function getSolicitors()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        return Mapper::fromSolicitors(...$this->solicitorService->getSolicitors($this->user->getAgent()));
    }

    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws AgencyNotFoundException
     */
    private function createSolicitor(): array
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters([
            'agency_id',
            'name',
            'email',
            'street',
            'house_number',
            'postcode',
            'city',
            'country',
        ]);

        $solicitor = new Solicitor();
        $agency    = $this->agencyService->getAgency((int)$this->parameters['agency_id']);

        $solicitor->setAgent($this->user->getAgent());
        $solicitor->setAgency($agency);

        $this->prepareParameters($solicitor);

        $solicitor = $this->solicitorService->createSolicitor($solicitor);

        return Mapper::fromSolicitor($solicitor);
    }


    /**
     * @return array
     * @throws NotAuthorizedException
     * @throws SolicitorNotFoundException
     */
    private function updateSolicitor()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters(['id']);

        $solicitor = $this->solicitorService->getSolicitor((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $solicitor->getAgent()->getId());

        $this->prepareParameters($solicitor);

        return Mapper::fromSolicitor($this->solicitorService->updateSolicitor($solicitor));
    }


    /**
     * @throws NotAuthorizedException
     * @throws SolicitorNotFoundException
     */
    private function deleteSolicitor()
    {
        $this->hasAccessLevel(self::USER_COLLEAGUE);

        $this->checkParameters(['id']);

        $solicitor = $this->solicitorService->getSolicitor((int)$this->parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getId(), $solicitor->getAgent()->getId());

        $this->solicitorService->deleteSolicitor($solicitor);
    }
}
