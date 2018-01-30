<?php
declare(strict_types=1);

namespace AppBundle\Security;

use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use AuthenticationBundle\Service\BlacklistService;
use Symfony\Component\HttpFoundation\Request;
use AuthenticationBundle\Service\UserService;

/**
 * Authenticator
 */
class Authenticator
{
    private const AUTHORIZATION_HEADER_PREFIX = "Basic ";

    /**
     * @var bool
     */
    private $strict;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var BlacklistService
     */
    private $blacklistService;

    /**
     * @param string           $environment
     * @param UserService      $userService
     * @param BlacklistService $blacklistService
     */
    public function __construct($environment, UserService $userService, BlacklistService $blacklistService)
    {
        $this->userService      = $userService;
        $this->blacklistService = $blacklistService;

        if ($environment === "dev") {
            $this->strict = false;
        } else {
            $this->strict = true;
        }
    }

    /**
     * @param Request $request
     * @param bool    $impersonate
     *
     * @return int $userId
     * @throws CouldNotAuthenticateUserException
     * @throws UserNotFoundException
     */
    public function authenticate(Request $request, bool $impersonate): int
    {
        $headers = $request->headers;
        if (!$headers->has('Authorization')) {
            throw new CouldNotAuthenticateUserException("No authorization header provided");
        }

        $authorizationHeader = $headers->get('Authorization');
        if (empty($authorizationHeader)) {
            throw new CouldNotAuthenticateUserException("No authorization header provided");
        }

        if (strpos($authorizationHeader, self::AUTHORIZATION_HEADER_PREFIX) !== 0) {
            throw new CouldNotAuthenticateUserException("Authorization method not recognized");
        }

        $decoded = json_decode(
            base64_decode(substr($authorizationHeader, mb_strlen(self::AUTHORIZATION_HEADER_PREFIX))),
            true
        );

        if ($decoded === null) {
            throw new CouldNotAuthenticateUserException("Could not decode authorization header");
        }

        $userId    = (int)$decoded['user'];
        $password  = $decoded['password'];
        $timestamp = $decoded['timestamp'];
        $signature = $decoded['signature'];

        $user = $this->userService->getUser($userId);

        if (empty($user)) {
            throw new CouldNotAuthenticateUserException("No user found");
        }

        if (!$user->getActive()) {
            throw new CouldNotAuthenticateUserException("User is not activated");
        }

        $secret = $user->getPassword();

        if ($password !== $secret) {
            throw new CouldNotAuthenticateUserException("Password incorrect");
        }


        if (hash_hmac('sha1', $timestamp . "-" . $userId, $secret) !== $signature) {
            throw new CouldNotAuthenticateUserException("User not recognized");
        }

        if (!$impersonate) {
            $user->setLastOnline(new \DateTime());
            $this->userService->updateUser($user);
        }

        if (!$this->strict) {
            return $userId;
        }

        $now                = time();
        $tenMinutesInPast   = $now - (10 * 60);
        $tenMinutesInFuture = $now + (10 * 60);

        if ($timestamp > $tenMinutesInFuture || $timestamp < $tenMinutesInPast) {
            if ($user->getLastOnline()) {
                if ($user->getLastOnline()->getTimestamp() < $tenMinutesInPast) {
                    throw new CouldNotAuthenticateUserException("Token is expired");
                }
            }
        }

        return $userId;
    }
}
