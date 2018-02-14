<?php declare(strict_types = 1);

namespace ConversationBundle\Service\Notification;

use ConversationBundle\Entity\Notification;

/**
 * Class Mapper
 * @package ConversationBundle\Service\Notification
 */
class Mapper
{
    /**
     * @param Notification $notification
     *
     * @return array
     */
    public static function fromNotification(Notification $notification): array
    {
        $end = null;
        if ($notification->getEnd() !== null) {
            $end = $notification->getEnd()->format("Y-m-d H:i:s");
        }

        return [
            'id'          => $notification->getId(),
            'content'     => $notification->getContent(),
            'type'        => $notification->getType(),
            'start'       => $notification->getStart()->format("Y-m-d H:i:s"),
            'end'         => $end,
            'important'   => $notification->isImportant(),
            'label'       => $notification->getLabel(),
            'removable'   => $notification->isRemovable(),
            'visible'     => $notification->isVisible(),
            'users'       => $notification->getUserIdentifiers(),
            'forEveryone' => $notification->isForEveryone(),
        ];
    }

    /**
     * @param Notification[] ...$notifications
     *
     * @return array
     */
    public static function fromNotifications(Notification ...$notifications): array
    {
        return array_map(
            function(Notification $notification) {
                return self::fromNotification($notification);
            },
            $notifications
        );
    }
}
