<?php
declare(strict_types=1);

namespace AlertBundle\Controller;

use AlertBundle\Entity\Applicant;
use AlertBundle\Exceptions\ApplicantAlreadyExistException;
use AlertBundle\Service\Applicant\Mapper;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AlertBundle\Exceptions\ApplicantNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AlertBundle\Controller\ApplicantController")
 */
class ApplicantController extends BaseController
{
    /**
     * @Route("/applicant" , name="applicant")
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
     * @throws ApplicantNotFoundException
     * @throws NotAuthorizedException
     */
    private function getApplicant(array $parameters): array
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $applicant = $this->applicantService->getApplicant((int)$parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getAgentGroup()->getId(), $applicant->getAgentGroup()->getId());

        return Mapper::fromApplicant($applicant);
    }

    /**
     * @return array
     */
    private function getApplicants(): array
    {
        return Mapper::fromApplicants(...
            $this->applicantService->getApplicants($this->user->getAgent()->getAgentGroup()));
    }

    /**
     * @param array $parameters
     *
     * @return array $user
     * @throws ApplicantAlreadyExistException
     */
    private function createApplicant(array $parameters)
    {
        $this->checkParameters([
            'name',
            'email',
        ], $parameters);

        if ($this->applicantService->getApplicantByEmail($parameters['email'])) {
            throw new ApplicantAlreadyExistException($parameters['email']);
        }

        $applicant = new Applicant();

        $applicant->setAgentGroup($this->user->getAgent()->getAgentGroup());
        $applicant->setCountry($this->user->getAgent()->getCountry());

        $this->prepareParameters($applicant, $parameters);

        return Mapper::fromApplicant($this->applicantService->createApplicant($applicant));
    }

    /**
     * @param array $parameters
     *
     * @throws ApplicantNotFoundException
     * @throws NotAuthorizedException
     */
    private function deleteApplicant(array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $applicant = $this->applicantService->getApplicant((int)$parameters['id']);

        $this->isAuthorized($this->user->getAgent()->getAgentGroup()->getId(), $applicant->getAgentGroup()->getId());

        $applications = $this->applicationService->getApplicationFromApplicant($applicant);

        foreach ($applications as $application) {
            $application->setActive(false);
            $this->applicationService->updateApplication($application);
        }

        $applicant->setActive(false);
        $this->applicantService->updateApplicant($applicant);
    }
}
