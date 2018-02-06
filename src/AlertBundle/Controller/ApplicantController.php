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
     * @throws ApplicantNotFoundException
     * @throws NotAuthorizedException
     */
    private function getApplicant(): array
    {
        $this->checkParameters(['id']);

        $applicant = $this->applicantService->getApplicant((int)$this->parameters['id']);

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
     * @return array $user
     * @throws ApplicantAlreadyExistException
     */
    private function createApplicant(): array
    {
        $this->checkParameters([
            'name',
            'email',
        ]);

        if ($this->applicantService->getApplicantByEmail($this->parameters['email'])) {
            throw new ApplicantAlreadyExistException($this->parameters['email']);
        }

        $applicant = new Applicant();

        $applicant->setAgentGroup($this->user->getAgent()->getAgentGroup());
        $applicant->setCountry($this->user->getAgent()->getCountry());

        $this->prepareParameters($applicant);

        return Mapper::fromApplicant($this->applicantService->createApplicant($applicant));
    }

    /**
     * @throws ApplicantNotFoundException
     * @throws NotAuthorizedException
     */
    private function deleteApplicant()
    {
        $this->checkParameters(['id']);

        $applicant = $this->applicantService->getApplicant((int)$this->parameters['id']);

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
