<?php declare(strict_types=1);

namespace LogBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Activity;
use LogBundle\Exceptions\ActivityNotFoundException;

/**
 * @package LogBundle\Service
 */
class ActivityService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Activity $activity
     *
     * @throws ActivityNotFoundException
     */
    public function getActivity(int $id)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Activity');
        $activity   = $repository->find($id);

        /** @var Activity $activity */
        if ($activity === null) {
            throw new ActivityNotFoundException($id);
        }

        return $activity;
    }

    /**
     * @param int         $userId
     * @param int|null    $actionId
     * @param null|string $actionCategory
     * @param string      $actionName
     * @param array|null  $oldValue
     * @param array       $newValue
     *
     * @return Activity
     */
    public function createActivity(
        int $userId,
        ?int $actionId,
        ?string $actionCategory,
        string $actionName,
        ?array $oldValue,
        array $newValue
    ) {
        $activity = new Activity();

        $activity->setUserId($userId);
        $activity->setActionId($actionId);
        $activity->setActionCategory($actionCategory);
        $activity->setActionName($actionName);
        $activity->setOldValue($oldValue);
        $activity->setNewValue($newValue);

        $this->entityManager->persist($activity);
        $this->entityManager->flush();

        return $activity;
    }
}
