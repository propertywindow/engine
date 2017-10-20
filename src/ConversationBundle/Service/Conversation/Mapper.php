<?php declare(strict_types=1);

namespace ConversationBundle\Service\Conversation;

use ConversationBundle\Entity\Conversation;

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
            'from_user_id' => $conversation->getFromUser(),
            'to_user_id'   => $conversation->getToUser(),
            'closed'       => $conversation->getClosed(),
            'last_message' => '',
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
}
