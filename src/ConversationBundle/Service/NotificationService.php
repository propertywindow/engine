<?php
declare(strict_types=1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Repository\UserRepository;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use ConversationBundle\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use ConversationBundle\Entity\Notification;

/**
 * Notification Service
 */
class NotificationService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var NotificationRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Notification::class);
    }

    /**
     * @param int $id
     *
     * @return Notification
     * @throws NotificationNotFoundException
     */
    public function getNotification(int $id): Notification
    {
        return $this->repository->findById($id);
    }

    /**
     * @param User $user
     *
     * @return Notification[]
     */
    public function getNotifications(User $user): array
    {
        return $this->repository->getByUserId($user->getId());
    }

    /**
     * @param User $user
     *
     * @return Notification[]
     */
    public function listNotifications(User $user): array
    {
        return $this->repository->listAll($user);
    }

    /**
     * @param Notification $notification
     * @param array        $userIdentifiers
     *
     * @return Notification
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createNotification(Notification $notification, array $userIdentifiers): Notification
    {
        $this->entityManager->persist($notification);
        $this->rebindNotificationForeignEntries($notification, $userIdentifiers);
        $this->entityManager->flush();

        return $notification;
    }

    /**
     * @param Notification $notification
     * @param array        $userIdentifiers
     *
     * @return Notification
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateNotification(Notification $notification, array $userIdentifiers): Notification
    {
        $this->rebindNotificationForeignEntries($notification, $userIdentifiers);
        $this->entityManager->flush();

        return $notification;
    }

    /**
     * @param int $id
     *
     * @throws NotificationNotFoundException
     */
    public function deleteNotification(int $id)
    {
        $notification = $this->repository->findById($id);

        $this->entityManager->remove($notification);
        $this->entityManager->flush();
    }

    /**
     * @param Notification $notification
     * @param int[]        $userIdentifiers
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function rebindNotificationForeignEntries(
        Notification $notification,
        array $userIdentifiers
    ) {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        $users          = $userRepository->findByUserIdentifiers(array_unique($userIdentifiers));

        $notification->setUsers($users);
    }
}
