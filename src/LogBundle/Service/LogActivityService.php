<?php
declare(strict_types=1);

namespace LogBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Activity;
use LogBundle\Exceptions\ActivityNotFoundException;
use LogBundle\Repository\ActivityRepository;

/**
 * @package LogBundle\Service
 */
class LogActivityService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ActivityRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Activity::class);
    }

    /**
     * @param int $id
     *
     * @return Activity
     * @throws ActivityNotFoundException
     */
    public function getActivity(int $id): Activity
    {
        return $this->repository->findById($id);
    }

    /**
     * @param Agent $agent
     *
     * @return Activity[]
     */
    public function getActivities(Agent $agent): array
    {
        return $this->repository->findByAgent($agent);
    }

    /**
     * @param Agent  $agent
     * @param string $type
     *
     * @return Activity[]
     */
    public function findPropertiesByAgent(Agent $agent, string $type): array
    {
        return $this->repository->findPropertiesByAgent($agent, $type);
    }

    /**
     * @param User $user
     *
     * @return Activity
     */
    public function getActivityFromUser(User $user): Activity
    {
        return $this->repository->findByUser($user);
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
