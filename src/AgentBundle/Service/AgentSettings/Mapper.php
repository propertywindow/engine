<?php declare(strict_types=1);

namespace AgentBundle\Service\AgentSettings;

use AgentBundle\Entity\AgentSettings;

/**
 * Class Mapper
 * @package AgentBundle\Service\AgentSettings
 */
class Mapper
{
    /**
     * @param AgentSettings $agentSettings
     *
     * @return array
     */
    public static function fromAgentSettings(AgentSettings $agentSettings): array
    {
        return [
            'agent_id'      => $agentSettings->getAgent()->getId(),
            'email_name'    => $agentSettings->getEmailName(),
            'email_address' => $agentSettings->getEmailAddress(),
            'IMAP_address'  => $agentSettings->getIMAPAddress(),
            'IMAP_secure'   => $agentSettings->getIMAPSecure(),
            'IMAP_port'     => $agentSettings->getIMAPPort(),
            'IMAP_username' => $agentSettings->getIMAPUsername(),
            'IMAP_password' => $agentSettings->getIMAPPassword(),
            'SMTP_address'  => $agentSettings->getSMTPAddress(),
            'SMTP_secure'   => $agentSettings->getSMTPSecure(),
            'SMTP_port'     => $agentSettings->getSMTPPort(),
            'SMTP_username' => $agentSettings->getSMTPUsername(),
            'SMTP_password' => $agentSettings->getSMTPPassword(),
        ];
    }
}
