<?php declare(strict_types=1);

namespace ConversationBundle\Service;

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
     * @return Notification[]
     */
    public function getNotifications()
    {
        $repository = $this->entityManager->getRepository('ConversationBundle:Notification');

        return $repository->listAll();
    }

    /**
     * @param Notification $notification
     *
     * @return Notification
     */
    public function createNotification(Notification $notification)
    {
        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        return $notification;
    }

    /**
     * @param Notification $notification
     *
     * @return Notification
     */
    public function updateNotification(Notification $notification)
    {
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
}
