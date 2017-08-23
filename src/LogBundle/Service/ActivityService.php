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
    public function getUser(int $id)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Activity');
        $activity   = $repository->find($id);

        if ($activity === null) {
            throw new ActivityNotFoundException($id);
        }

        return $activity;
    }

    /**
     * @param int    $userId
     * @param string $action
     * @param array|null  $oldValue
     * @param array  $newValue
     *
     * @return Activity
     */
    public function createActivity(int $userId, string $action, ?array $oldValue, array $newValue)
    {
        $activity = new Activity();

        $activity->setUserId($userId);
        $activity->setAction($action);
        $activity->setOldValue($oldValue);
        $activity->setNewValue($newValue);

        $this->entityManager->persist($activity);
        $this->entityManager->flush();

        return $activity;
    }
}
