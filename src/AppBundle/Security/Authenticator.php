<?php
declare(strict_types=1);

namespace AppBundle\Security;

use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AuthenticationBundle\Entity\User;
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
     * @var User $user
     */
    private $user;

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

        $userId     = (int)$decoded['user'];
        $this->user = $this->userService->getUser($userId);

        $this->validateUser($decoded);

        if (!$impersonate) {
            $this->user->setLastOnline(new \DateTime());
            $this->userService->updateUser($this->user);
        }

        if (!$this->strict) {
            return $userId;
        }

        $this->checkExpired($decoded['timestamp']);

        return $userId;
    }


    /**
     * @param  $timestamp
     *
     * @throws CouldNotAuthenticateUserException
     */
    private function checkExpired($timestamp)
    {
        $now                = time();
        $tenMinutesInPast   = $now - (10 * 60);
        $tenMinutesInFuture = $now + (10 * 60);

        if ($timestamp > $tenMinutesInFuture || $timestamp < $tenMinutesInPast) {
            if ($this->user->getLastOnline()) {
                if ($this->user->getLastOnline()->getTimestamp() < $tenMinutesInPast) {
                    throw new CouldNotAuthenticateUserException("Token is expired");
                }
            }
        }
    }

    /**
     * @param array $decoded
     *
     * @throws CouldNotAuthenticateUserException
     */
    private function validateUser(array $decoded)
    {
        if (empty($this->user)) {
            throw new CouldNotAuthenticateUserException("No user found");
        }

        if (!$this->user->getActive()) {
            throw new CouldNotAuthenticateUserException("User is not activated");
        }

        $secret = $this->user->getPassword();
        $hash   = hash_hmac('sha1', $decoded['timestamp'] . "-" . (int)$decoded['user'], $secret);

        if (!hash_equals($decoded['password'], $secret)) {
            throw new CouldNotAuthenticateUserException("Password incorrect");
        }

        if (!hash_equals($hash, $decoded['signature'])) {
            throw new CouldNotAuthenticateUserException("User not recognized");
        }
    }
}
