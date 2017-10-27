<?php declare(strict_types=1);

namespace AgentBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Exceptions\NotAuthorizedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AgentBundle\Exceptions\AgentNotFoundException;
use AgentBundle\Service\AgentSettings\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="agent_settings_controller")
 */
class AgentSettingsController extends BaseController
{
    /**
     * @Route("/agent_settings" , name="agent_settings")
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
            $jsonRpcResponse = $this->throwable($throwable);
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
     * @throws AgentNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getSettings":
                return $this->getSettings($userId);
            case "updateSettings":
                return $this->updateSettings($userId, $parameters);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int $userId
     *
     * @return array
     *
     * @throws AgentNotFoundException
     */
    private function getSettings(int $userId)
    {
        $user = $this->userService->getUser($userId);

        return Mapper::fromAgentSettings($this->agentSettingsService->getSettings($user->getAgent()));
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws NotAuthorizedException
     */
    private function updateSettings(int $userId, array $parameters)
    {
        $user     = $this->userService->getUser($userId);
        $settings = $this->agentSettingsService->getSettings($user->getAgent());

        if ((int)$user->getUserType()->getId() > self::USER_AGENT) {
            throw new NotAuthorizedException($userId);
        }

        if ($settings->getAgent()->getId() !== $user->getAgent()->getId()) {
            if ((int)$user->getUserType()->getId() !== self::USER_ADMIN) {
                throw new NotAuthorizedException($userId);
            }
        }

        if (array_key_exists('email_name', $parameters) && $parameters['email_name'] !== null) {
            $settings->setEmailName(ucwords($parameters['email_name']));
        }
        if (array_key_exists('email_address', $parameters) && $parameters['email_address'] !== null) {
            $settings->setEmailAddress($parameters['email_address']);
        }
        if (array_key_exists('IMAP_address', $parameters) && $parameters['IMAP_address'] !== null) {
            $settings->setIMAPAddress($parameters['IMAP_address']);
        }
        if (array_key_exists('IMAP_secure', $parameters) && $parameters['IMAP_secure'] !== null) {
            $settings->setIMAPSecure($parameters['IMAP_secure']);
        }
        if (array_key_exists('IMAP_port', $parameters) && $parameters['IMAP_port'] !== null) {
            $settings->setIMAPPort($parameters['IMAP_port']);
        }
        if (array_key_exists('IMAP_username', $parameters) && $parameters['IMAP_username'] !== null) {
            $settings->setIMAPUsername($parameters['IMAP_username']);
        }
        if (array_key_exists('IMAP_password', $parameters) && $parameters['IMAP_password'] !== null) {
            $settings->setIMAPPassword($parameters['IMAP_password']);
        }
        if (array_key_exists('SMTP_address', $parameters) && $parameters['SMTP_address'] !== null) {
            $settings->setSMTPAddress($parameters['SMTP_address']);
        }
        if (array_key_exists('SMTP_secure', $parameters) && $parameters['SMTP_secure'] !== null) {
            $settings->setSMTPSecure($parameters['SMTP_secure']);
        }
        if (array_key_exists('SMTP_port', $parameters) && $parameters['SMTP_port'] !== null) {
            $settings->setSMTPPort($parameters['SMTP_port']);
        }
        if (array_key_exists('SMTP_username', $parameters) && $parameters['SMTP_username'] !== null) {
            $settings->setSMTPUsername($parameters['SMTP_username']);
        }
        if (array_key_exists('SMTP_password', $parameters) && $parameters['SMTP_password'] !== null) {
            $settings->setSMTPPassword($parameters['SMTP_password']);
        }

        return Mapper::fromAgentSettings($this->agentSettingsService->updateSettings($settings));
    }
}
