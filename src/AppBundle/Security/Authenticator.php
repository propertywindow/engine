<?php declare(strict_types=1);

namespace AppBundle\Security;

use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AuthenticationBundle\Service\BlacklistService;
use Symfony\Component\HttpFoundation\Request;
use AuthenticationBundle\Service\UserService;

/**
 * @package AppBundle\Security
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
     * @var UserService
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
     *
     * @return int
     *
     * @throws CouldNotAuthenticateUserException
     */
    public function authenticate(Request $request): int
    {
        $ipAddress = $request->getClientIp();
        $blacklist = $this->blacklistService->checkBlacklist($ipAddress);

        if ($blacklist && $blacklist->getAmount() >= 5) {
            throw new CouldNotAuthenticateUserException("You're IP address ($ipAddress) has been blocked");
        }

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

        if (!$this->strict) {
            return $userId;
        }

        $user = $this->userService->getUser($userId);

        if (empty($user)) {
            throw new CouldNotAuthenticateUserException("No user found");
        }

        $secret = $user->getPassword();

        if (md5($password) !== $secret) {
            throw new CouldNotAuthenticateUserException("Password incorrect");
        }


        if (hash_hmac('sha1', $timestamp."-".$userId, $secret) !== $signature) {
            throw new CouldNotAuthenticateUserException("User not recognized");
        }

        $now                = time();
        $tenMinutesInPast   = $now - (10 * 60);
        $tenMinutesInFuture = $now + (10 * 60);

        if ($timestamp > $tenMinutesInFuture || $timestamp < $tenMinutesInPast) {
            throw new CouldNotAuthenticateUserException("Token is expired");
        }

        return $userId;
    }
}
