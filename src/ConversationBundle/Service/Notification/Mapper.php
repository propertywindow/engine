<?php declare(strict_types=1);

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
        return [
            'id'           => $notification->getId(),
            'user_id'      => $notification->getUser(),
            'notification' => $notification->getNotification(),
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
            function (Notification $notification) {
                return self::fromNotification($notification);
            },
            $notifications
        );
    }
}
