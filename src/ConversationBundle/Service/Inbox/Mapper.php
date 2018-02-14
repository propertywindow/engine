<?php declare(strict_types = 1);

namespace ConversationBundle\Service\Inbox;

use ConversationBundle\Entity\Email;
use ConversationBundle\Entity\Mailbox;

/**
 * Class Mapper
 * @package ConversationBundle\Service\Inbox
 */
class Mapper
{
    /**
     * @param Email $email
     *
     * @return array
     */
    public static function fromEmail(Email $email): array
    {
        return [
            'id'      => $email->getId(),
            'subject' => $email->getSubject(),
            'from'    => $email->getFrom(),
            'date'    => $email->getDate(),
        ];
    }

    /**
     * @param Email[] ...$emails
     *
     * @return array
     */
    public static function fromMailbox(Email ...$emails): array
    {
        return array_map(
            function(Email $email) {
                return self::fromEmail($email);
            },
            $emails
        );
    }

    /**
     * @param Mailbox[] ...$mailboxes
     *
     * @return array
     */
    public static function fromMailboxes(Mailbox ...$mailboxes): array
    {
        return array_map(
            function(Mailbox $mailbox) {
                return [
                    'id'      => $mailbox->getId(),
                    'name'    => $mailbox->getName(),
                    'mailbox' => $mailbox->getMailbox(),
                    'unread'  => $mailbox->getUnread(),
                ];
            },
            $mailboxes
        );
    }
}
