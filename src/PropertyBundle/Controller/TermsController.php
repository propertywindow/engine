<?php
declare(strict_types = 1);

namespace PropertyBundle\Controller;

use AppBundle\Controller\JsonController;
use PropertyBundle\Exceptions\TermsNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use PropertyBundle\Service\Terms\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="PropertyBundle\Controller\TermsController")
 */
class TermsController extends JsonController
{
    /**
     * @Route("/property/terms" , name="terms")
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
     * @throws TermsNotFoundException
     */
    private function getTerm(): array
    {
        $this->checkParameters(['id']);

        return Mapper::fromTerm(
            $this->user->getSettings()->getLanguage(),
            $this->termsService->getTerm((int) $this->parameters['id'])
        );
    }

    /**
     * @return array
     */
    private function getTerms(): array
    {
        return Mapper::fromTerms(
            $this->user->getSettings()->getLanguage(),
            ...$this->termsService->getTerms()
        );
    }
}
