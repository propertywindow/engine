<?php declare(strict_types=1);

namespace AlertBundle\Controller;

use AlertBundle\Entity\Applicant;
use AlertBundle\Exceptions\ApplicantAlreadyExistException;
use AlertBundle\Service\Applicant\Mapper;
use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use InvalidArgumentException;
use AlertBundle\Exceptions\ApplicantNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="applicant_controller")
 */
class ApplicantController extends BaseController
{
    /**
     * @Route("/applicant" , name="applicant")
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
     *
     * @throws InvalidJsonRpcMethodException
     * @throws ApplicantNotFoundException
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
     *
     * @throws NotAuthorizedException
     */
    private function getApplicant(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id        = (int)$parameters['id'];
        $user      = $this->userService->getUser($userId);
        $applicant = $this->applicantService->getApplicant($id);

        if ($user->getAgent()->getAgentGroup() !== $applicant->getAgentGroup()) {
            throw new NotAuthorizedException($userId);
        }

        return Mapper::fromApplicant($applicant);
    }

    /**
     * @param int $userId
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function getApplicants(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromApplicants(...$this->applicantService->getApplicants($user->getAgent()->getAgentGroup()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array $user
     *
     * @throws NotAuthorizedException
     * @throws ApplicantAlreadyExistException
     */
    private function createApplicant(int $userId, array $parameters)
    {
        $user = $this->userService->getUser($userId);

        if (!array_key_exists('name', $parameters) && $parameters['name'] !== null) {
            throw new InvalidArgumentException("name parameter not provided");
        }
        if (!array_key_exists('email', $parameters) && $parameters['email'] !== null) {
            throw new InvalidArgumentException("email parameter not provided");
        }
        if (!filter_var($parameters['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("email parameter not valid");
        }

        if ($this->applicantService->getApplicantByEmail($parameters['email'])) {
            throw new ApplicantAlreadyExistException($parameters['email']);
        }

        $applicant = new Applicant();

        $applicant->setAgentGroup($user->getAgent()->getAgentGroup());
        $applicant->setName($parameters['name']);
        $applicant->setEmail($parameters['email']);
        $applicant->setCountry($user->getAgent()->getCountry());

        if (array_key_exists('protection', $parameters) && $parameters['protection'] !== null) {
            $applicant->setProtection($parameters['protection']);
        }

        if (array_key_exists('phone', $parameters) && $parameters['phone'] !== null) {
            $applicant->setPhone($parameters['phone']);
        }

        return Mapper::fromApplicant($this->applicantService->createApplicant($applicant));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @throws NotAuthorizedException
     */
    private function deleteApplicant(int $userId, array $parameters)
    {
        if (!array_key_exists('id', $parameters)) {
            throw new InvalidArgumentException("No argument provided");
        }

        $id        = (int)$parameters['id'];
        $user      = $this->userService->getUser($userId);
        $applicant = $this->applicantService->getApplicant($id);

        if ($user->getAgent()->getAgentGroup() !== $applicant->getAgentGroup()) {
            throw new NotAuthorizedException($userId);
        }

        $applications = $this->applicationService->getApplicationFromApplicant($applicant);

        foreach ($applications as $application) {
            $application->setActive(false);
            $this->applicationService->updateApplication($application);
        }

        $applicant->setActive(false);
        $this->applicantService->updateApplicant($applicant);
    }
}
