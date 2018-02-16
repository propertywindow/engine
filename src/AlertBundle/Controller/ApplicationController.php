<?php
declare(strict_types = 1);

namespace AlertBundle\Controller;

use AlertBundle\Entity\Application;
use AlertBundle\Exceptions\ApplicantNotFoundException;
use AlertBundle\Exceptions\ApplicationNotFoundException;
use AlertBundle\Service\Application\Mapper;
use AppBundle\Controller\JsonController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use PropertyBundle\Exceptions\KindNotFoundException;
use PropertyBundle\Exceptions\SubTypeNotFoundException;
use PropertyBundle\Exceptions\TermsNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AlertBundle\Controller\ApplicationController")
 */
class ApplicationController extends JsonController
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
     * @throws ApplicationNotFoundException
     * @throws NotAuthorizedException
     */
    private function getApplication(): array
    {
        $this->checkParameters(['id']);

        $applicant = $this->applicationService->getApplication((int)$this->parameters['id']);

        $this->isAuthorized(
            $this->user->getAgent()->getAgentGroup()->getId(),
            $applicant->getApplicant()->getAgentGroup()->getId()
        );

        return Mapper::fromApplication($applicant);
    }

    /**
     * @return array
     * @throws ApplicantNotFoundException
     */
    private function getApplicationFromApplicant(): array
    {
        $this->checkParameters(['applicant_id']);

        $applicant = $this->applicantService->getApplicant((int)$this->parameters['applicant_id']);

        return Mapper::fromApplications(...
            $this->applicationService->getApplicationFromApplicant($applicant));
    }

    /**
     * @return array $user
     * @throws ApplicantNotFoundException
     * @throws KindNotFoundException
     * @throws SubTypeNotFoundException
     * @throws TermsNotFoundException
     */
    private function createApplication(): array
    {
        $this->checkParameters([
            'applicant_id',
            'kind_id',
            'subtype_id',
            'terms_id',
            'postcode',
            'distance',
        ]);

        $applicant = $this->applicantService->getApplicant((int)$this->parameters['applicant_id']);
        $kind      = $this->kindService->getKind((int)$this->parameters['kind_id']);
        $subtype   = $this->subTypeService->getSubType((int)$this->parameters['subtype_id']);
        $terms     = $this->termsService->getTerm((int)$this->parameters['terms_id']);

        $application = new Application();

        $application->setApplicant($applicant);
        $application->setKind($kind);
        $application->setSubType($subtype);
        $application->setTerms($terms);
        $application->setCountry($this->user->getAgent()->getAddress()->getCountry());
        $application->setActive(true);

        $this->prepareParameters($application);

        return Mapper::fromApplication($this->applicationService->createApplication($application));
    }

    /**
     * @throws NotAuthorizedException
     * @throws ApplicationNotFoundException
     */
    private function deleteApplication()
    {
        $this->checkParameters(['id']);

        $application = $this->applicationService->getApplication((int)$this->parameters['id']);

        $this->isAuthorized(
            $this->user->getAgent()->getAgentGroup()->getId(),
            $application->getApplicant()->getAgentGroup()->getId()
        );

        $application->setActive(false);
        $this->applicationService->updateApplication($application);
    }
}
