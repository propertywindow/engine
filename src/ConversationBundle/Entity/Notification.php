<?php declare(strict_types=1);

namespace ConversationBundle\Entity;

use AuthenticationBundle\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\NotificationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Notification
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
     * @ORM\ManyToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AuthenticationBundle\Entity\User", inversedBy="notifications")
     * @ORM\JoinTable(
     *          name="notification_user_maps",
     *          joinColumns={@ORM\JoinColumn(name="notification_id", referencedColumnName="id")},
     *          inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *     )
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="label", nullable=true, type="text")
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text")
     */
    private $type;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * @var bool
     *
     * @ORM\Column(name="removable", type="boolean", options={"default": false})
     */
    private $removable;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", options={"default": true})
     */
    private $visible;

    /**
     * @var bool
     *
     * @ORM\Column(name="important", type="boolean", options={"default": false})
     */
    private $important;

    /**
     * @var bool
     *
     * @ORM\Column(name="for_everyone", type="boolean", options={"default": false})
     */
    private $forEveryone;

    /**
     * @var DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->users       = new ArrayCollection();

        $this->removable   = false;
        $this->visible     = true;
        $this->important   = false;
        $this->forEveryone = false;
    }

    /**
     * id
     *
     * @param int $id
     *
     * @return Notification
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \AuthenticationBundle\Entity\User $user
     *
     * @return Notification
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
     * @return \AuthenticationBundle\Entity\User[]
     */
    public function getUsers(): array
    {
        return $this->users->getValues();
    }

    /**
     * @return int[]
     */
    public function getUserIdentifiers(): array
    {
        return array_map(
            function (User $user) {
                return $user->getId();
            },
            $this->users->toArray()
        );
    }

    /**
     * @param \AuthenticationBundle\Entity\User[] $users
     */
    public function setUsers(array $users)
    {
        foreach ($this->users->getKeys() as $userId) {
            $found = false;
            foreach ($users as $user) {
                if ($user->getId() === $userId) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $this->users->remove($userId);
            }
        }

        foreach ($users as $key => $user) {
            if (!$this->users->contains($user)) {
                $this->users->add($user);
            }
        }
    }

    /**
     * content
     *
     * @param string $content
     *
     * @return Notification
     */
    public function setContent(string $content): Notification
    {
        $this->content = $content;

        return $this;
    }

    /**
     * content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * label
     *
     * @param string $label
     *
     * @return Notification
     */
    public function setLabel(?string $label)
    {
        $this->label = $label;
    }

    /**
     * label
     *
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * type
     *
     * @param string $type
     *
     * @return Notification
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * type
     *
     * @return string $type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * start
     *
     * @param DateTime $start
     *
     * @return Notification
     */
    public function setStart(DateTime $start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * start
     *
     * @return DateTime
     */
    public function getStart(): DateTime
    {
        return $this->start;
    }

    /**
     * end
     *
     * @param DateTime|null $end
     *
     * @return Notification
     */
    public function setEnd(?DateTime $end = null)
    {
        if ($end !== null && $end < $this->start) {
            throw new InvalidArgumentException(
                "End: '
                {$end->format("Y-m-d H:i:s")}
                ' cannot be before start: '
                {$this->start->format("Y-m-d H:i:s")}
                '"
            );
        }

        $this->end = $end;

        return $this;
    }

    /**
     * end
     *
     * @return DateTime|null
     */
    public function getEnd():?DateTime
    {
        return $this->end;
    }

    /**
     * removable
     *
     * @param bool $removable
     *
     * @return Notification
     */
    public function setRemovable(bool $removable)
    {
        $this->removable = $removable;

        return $this;
    }

    /**
     * removable
     *
     * @return bool
     */
    public function isRemovable(): bool
    {
        return $this->removable;
    }

    /**
     * visible
     *
     * @param boolean $visible
     *
     * @return Notification
     */
    public function setVisible(bool $visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * visible
     *
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * important
     *
     * @param boolean $important
     *
     * @return Notification
     */
    public function setImportant(bool $important)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * important
     *
     * @return bool
     */
    public function isImportant(): bool
    {
        return $this->important;
    }

    /**
     * @ORM\PreFlush()
     */
    public function markForEveryone()
    {
        $this->forEveryone = $this->isForEveryone();
    }

    /**
     * @return bool
     */
    public function isForEveryone(): bool
    {
        return
            $this->users->count() === 0;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new DateTime("now");
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new DateTime("now");
    }
}
