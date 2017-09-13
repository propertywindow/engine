<?php declare(strict_types=1);

namespace LogBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
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
     */
    public function getActivity(int $id)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Activity');
        $activity   = $repository->findById($id);

        return $activity;
    }

    /**
     * @param Agent $agent
     *
     * @return Activity[]
     */
    public function getActivities(Agent $agent)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Activity');

        return $repository->findByAgent($agent);
    }

    /**
     * @param Agent $agent
     * @param string $type
     *
     * @return Activity[]
     */
    public function findPropertiesByAgent(Agent $agent, string $type)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Activity');

        return $repository->findPropertiesByAgent($agent, $type);
    }

    /**
     * @param User $user
     *
     * @return Activity $activity
     *
     * @throws ActivityNotFoundException
     */
    public function getActivityFromUser(User $user)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Activity');
        $activity   = $repository->findByUser($user);

        return $activity;
    }

    /**
     * @param User        $user
     * @param int|null    $actionId
     * @param null|string $actionCategory
     * @param string      $actionName
     * @param string|null $oldValue
     * @param string      $newValue
     *
     * @return Activity
     */
    public function createActivity(
        User $user,
        ?int $actionId,
        ?string $actionCategory,
        string $actionName,
        ?string $oldValue,
        string $newValue
    ) {
        $activity = new Activity();

        $activity->setUser($user);
        $activity->setAgent($user->getAgent());
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
