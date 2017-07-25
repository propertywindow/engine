<?php declare(strict_types=1);

namespace AppBundle\Security;

use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package AppBundle\Security
 */
class Authenticator
{
    private const AUTHORIZATION_HEADER_PREFIX = "Basic ";

    /**
     * @var string[]
     */
    private $applications;

    /**
     * @var bool
     */
    private $strict;

    /**
     * @param string[] $applications
     * @param string   $environment
     */
    public function __construct($applications, $environment)
    {
        $this->applications = $applications;

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
        $apiKey    = $decoded['api'];
        $timestamp = $decoded['timestamp'];
        $signature = $decoded['signature'];

        if (!$this->strict) {
            return $userId;
        }

        if (!array_key_exists($apiKey, $this->applications)) {
            throw new CouldNotAuthenticateUserException("User not recognized");
        }

        $secret = $this->applications[$apiKey];

        if (hash_hmac('sha1', $timestamp . "-" . $userId, $secret) !== $signature) {
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
