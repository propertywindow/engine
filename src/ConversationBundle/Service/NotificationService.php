<?php declare(strict_types=1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ConversationBundle\Entity\Notification;

/**
 * @package ConversationBundle\Service
 */
class NotificationService
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
     * @return Notification $notification
     */
    public function getNotification(int $id)
    {
        $repository   = $this->entityManager->getRepository('ConversationBundle:Notification');
        $notification = $repository->findById($id);

        return $notification;
    }

    /**
     * @param User $user
     *
     * @return Notification[]
     */
    public function getNotifications(User $user)
    {
        $repository = $this->entityManager->getRepository('ConversationBundle:Notification');

        return $repository->getByUserId($user->getId());
    }

    /**
     * @param User $user
     *
     * @return Notification[]
     */
    public function listNotifications(User $user)
    {
        $repository = $this->entityManager->getRepository('ConversationBundle:Notification');

        return $repository->listAll($user);
    }

    /**
     * @param Notification $notification
     *
     * @param array        $userIdentifiers
     *
     * @return Notification
     */
    public function createNotification(Notification $notification, array $userIdentifiers)
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
     */
    public function updateNotification(Notification $notification, array $userIdentifiers)
    {
        $this->rebindNotificationForeignEntries($notification, $userIdentifiers);
        $this->entityManager->flush();

        return $notification;
    }

    /**
     * @param int $id
     */
    public function deleteNotification(int $id)
    {
        $notificationRepository = $this->entityManager->getRepository('ConversationBundle:Notification');
        $notification           = $notificationRepository->findById($id);

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
        $userRepository = $this->entityManager->getRepository('AuthenticationBundle:User');
        $users          = $userRepository->findByUserIdentifiers(array_unique($userIdentifiers));

        $notification->setUsers($users);
    }
}