<?php declare(strict_types=1);

namespace ConversationBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationMapper
 *
 * @ORM\Table(name="notification_mapper")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\NotificationMapperRepository")
 * @ORM\HasLifecycleCallbacks
 */
class NotificationMapper
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ConversationBundle\Entity\Notification")
     * @ORM\JoinColumn(name="notification_id", referencedColumnName="id")
     */
    private $notification;

    /**
     * @ORM\ManyToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="seen", type="boolean", options={"default": false})
     */
    private $seen;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set notification
     *
     * @param Notification $notification
     *
     * @return NotificationMapper
     */
    public function setNotification(Notification $notification = null)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Get notification
     *
     * @return NotificationMapper
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set user
     *
     * @param \AuthenticationBundle\Entity\User $user
     *
     * @return NotificationMapper
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AuthenticationBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * seen
     *
     * @param boolean $seen
     *
     * @return NotificationMapper
     */
    public function setSeen(bool $seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * seen
     *
     * @return bool
     */
    public function isSeen(): bool
    {
        return $this->seen;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}
