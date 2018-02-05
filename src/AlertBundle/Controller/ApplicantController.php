<?php
declare(strict_types=1);

namespace AlertBundle\Controller;

use AlertBundle\Entity\Applicant;
use AlertBundle\Exceptions\ApplicantAlreadyExistException;
use AlertBundle\Service\Applicant\Mapper;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
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
     * @throws ApplicantAlreadyExistException
     * @throws ApplicantNotFoundException
     * @throws InvalidJsonRpcMethodException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getApplicant":
                return $this->getApplicant($userId, $parameters);
            case "getApplicants":
                return $this->getApplicants($userId);
            case "createApplicant":
                return $this->createApplicant($userId, $parameters);
            case "deleteApplicant":
                return $this->deleteApplicant($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws ApplicantNotFoundException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function getApplicant(int $userId, array $parameters): array
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $id        = (int)$parameters['id'];
        $user      = $this->userService->getUser($userId);
        $applicant = $this->applicantService->getApplicant($id);

        $this->isAuthorized($user->getAgent()->getAgentGroup()->getId(), $applicant->getAgentGroup()->getId());

        return Mapper::fromApplicant($applicant);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws UserNotFoundException
     */
    private function getApplicants(int $userId): array
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromApplicants(...$this->applicantService->getApplicants($user->getAgent()->getAgentGroup()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     * @throws ApplicantAlreadyExistException
     * @throws UserNotFoundException
     */
    private function createApplicant(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        $this->checkParameters([
            'name',
            'email',
        ], $parameters);

        if ($this->applicantService->getApplicantByEmail($parameters['email'])) {
            throw new ApplicantAlreadyExistException($parameters['email']);
        }

        $applicant = new Applicant();

        $applicant->setAgentGroup($user->getAgent()->getAgentGroup());
        $applicant->setCountry($user->getAgent()->getCountry());

        $this->prepareParameters($applicant, $parameters);

        return Mapper::fromApplicant($this->applicantService->createApplicant($applicant));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws ApplicantNotFoundException
     * @throws NotAuthorizedException
     * @throws UserNotFoundException
     */
    private function deleteApplicant(int $userId, array $parameters)
    {
        $this->checkParameters([
            'id',
        ], $parameters);

        $user      = $this->userService->getUser($userId);
        $applicant = $this->applicantService->getApplicant((int)$parameters['id']);

        $this->isAuthorized($user->getAgent()->getAgentGroup()->getId(), $applicant->getAgentGroup()->getId());

        $applications = $this->applicationService->getApplicationFromApplicant($applicant);

        foreach ($applications as $application) {
            $application->setActive(false);
            $this->applicationService->updateApplication($application);
        }

        $applicant->setActive(false);
        $this->applicantService->updateApplicant($applicant);
    }
}
