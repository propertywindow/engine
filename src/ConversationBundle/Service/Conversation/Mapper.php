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
            'from_user_id' => $conversation->getFromUser()->getId(),
            'to_user_id'   => $conversation->getToUser()->getId(),
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
                    'id'           => $message->getId(),
                    'from_user_id' => $message->getFromUser()->getId(),
                    'to_user_id'   => $message->getToUser()->getId(),
                    'message'      => $message->getMessage(),
                    'seen'         => $message->getSeen(),
                    'read'         => $message->getUpdated(),
                    'date'         => $message->getCreated(),
                ];
            },
            $messages
        );
    }
}
