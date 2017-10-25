<?php declare(strict_types=1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Exceptions\NotificationNotCloseableException;
use ConversationBundle\Exceptions\NotificationNotFoundException;
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

        return $repository->getByUser($user);
    }

    /**
     * @return Notification[]
     */
    public function listNotifications()
    {
        $repository = $this->entityManager->getRepository('ConversationBundle:Notification');

        return $repository->listAll();
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

        // todo: also delete from mapper, cascade delete?

        $this->entityManager->remove($notification);
        $this->entityManager->flush();
    }

    /**
     * @param int $notificationId
     * @param int $userId
     *
     * @throws NotificationNotCloseableException
     * @throws NotificationNotFoundException
     */
    public function closeNotification(int $notificationId, int $userId)
    {
        $criteria   = ['notification' => $notificationId, 'userId' => $userId];
        $repository = $this->entityManager->getRepository('ConversationBundle:NotificationMapper');
        $mapper     = $repository->findOneBy($criteria);

        if ($mapper === null) {
            throw new NotificationNotFoundException($notificationId);
        }

        $notification = $this->entityManager
            ->getRepository('ConversationBundle:Notification')
            ->findById($notificationId);

        if (!$notification->isRemovable()) {
            throw new NotificationNotCloseableException($notificationId);
        }

        $mapper->setSeen(true);

        $this->entityManager->persist($mapper);

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

        $users = $userRepository->findByUserIdentifiers(array_unique($userIdentifiers));

        $notification->setUsers(
            array_filter(
                $users,
                function (User $user) use ($userIdentifiers) {
                    return in_array($user->getId(), $userIdentifiers);
                }
            )
        );
        $notification->setCalculatedUsers($users);
    }
}
