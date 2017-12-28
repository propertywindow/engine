<?php declare(strict_types=1);

namespace ConversationBundle\Service\Conversation;

use ConversationBundle\Entity\Conversation;
use ConversationBundle\Entity\Message;

/**
 * Class Mapper
 * @package ConversationBundle\Service\Conversation
 */
class Mapper
{
    /**
     * @param Conversation $conversation
     *
     * @return array
     */
    public static function fromConversation(Conversation $conversation): array
    {
        return [
            'id'           => $conversation->getId(),
            'author_id'    => $conversation->getAuthor()->getId(),
            'recipient_id' => $conversation->getRecipient()->getId(),
            'unique_id'    => $conversation->getUniqueId(),
        ];
    }

    /**
     * @param Conversation[] ...$conversations
     *
     * @return array
     */
    public static function fromConversations(Conversation ...$conversations): array
    {
        return array_map(
            function (Conversation $conversation) {
                return self::fromConversation($conversation);
            },
            $conversations
        );
    }


    /**
     * @param Message[] ...$messages
     *
     * @return array
     */
    public static function fromMessages(Message ...$messages): array
    {
        return array_map(
            function (Message $message) {
                return [
                    'id'                => $message->getId(),
                    'author_id'         => $message->getAuthor()->getId(),
                    'recipient_id'      => $message->getRecipient()->getId(),
                    'message'           => $message->getMessage(),
                    'seen'              => $message->getSeen(),
                    'read'              => $message->getUpdated(),
                    'date'              => $message->getCreated(),
                ];
            },
            $messages
        );
    }
}
