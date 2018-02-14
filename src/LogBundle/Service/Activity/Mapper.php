<?php declare(strict_types = 1);

namespace LogBundle\Service\Activity;

use LogBundle\Entity\Activity;

/**
 * Class Mapper
 * @package LogBundle\Service\Activity
 */
class Mapper
{
    /**
     * @param Activity $activity
     *
     * @return array
     */
    public static function fromActivity(Activity $activity): array
    {

        return [
            'id'              => $activity->getId(),
            'user_id'         => $activity->getUser()->getId(),
            'user_name'       => $activity->getUser()->getFirstName() . ' ' . $activity->getUser()->getLastName(),
            'action_category' => $activity->getActionCategory(),
            'action_name'     => $activity->getActionName(),
            'action_id'       => $activity->getActionId(),
            'old_value'       => $activity->getOldValue(),
            'new_value'       => $activity->getNewValue(),
            'datetime'        => $activity->getCreated()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param Activity[] ...$activities
     *
     * @return array
     */
    public static function fromActivities(Activity ...$activities): array
    {
        return array_map(
            function(Activity $activity) {
                return self::fromActivity($activity);
            },
            $activities
        );
    }
}
