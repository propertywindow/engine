<?php declare(strict_types = 1);

namespace AuthenticationBundle\Service\UserSettings;

use AuthenticationBundle\Entity\UserSettings;

/**
 * Class Mapper
 * @package AuthenticationBundle\Service\UserSettings
 */
class Mapper
{
    /**
     * @param UserSettings $userSettings
     *
     * @return array
     */
    public static function fromUserSettings(UserSettings $userSettings): array
    {
        return [
            'user_id'       => $userSettings->getUser()->getId(),
            'language'      => $userSettings->getLanguage(),
            'email_name'    => $userSettings->getEmailName(),
            'email_address' => $userSettings->getEmailAddress(),
            'IMAP_address'  => $userSettings->getIMAPAddress(),
            'IMAP_secure'   => $userSettings->getIMAPSecure(),
            'IMAP_port'     => $userSettings->getIMAPPort(),
            'IMAP_username' => $userSettings->getIMAPUsername(),
            'IMAP_password' => $userSettings->getIMAPPassword(),
            'SMTP_address'  => $userSettings->getSMTPAddress(),
            'SMTP_secure'   => $userSettings->getSMTPSecure(),
            'SMTP_port'     => $userSettings->getSMTPPort(),
            'SMTP_username' => $userSettings->getSMTPUsername(),
            'SMTP_password' => $userSettings->getSMTPPassword(),
        ];
    }
}
