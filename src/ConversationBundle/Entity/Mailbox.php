<?php declare(strict_types = 1);

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="mailbox")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\MailboxRepository")
 */
class Mailbox
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="mailbox", type="string", length=255)
     */
    private $mailbox;

    /**
     * @var int
     * @ORM\Column(name="unread", type="integer")
     */
    private $unread = 0;

    /**
     * @var \DateTime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime $updated
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @param int $id
     *
     * @return Mailbox
     */
    public function setId(int $id): Mailbox
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return Mailbox
     */
    public function setName(string $name): Mailbox
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $mailbox
     *
     * @return Mailbox
     */
    public function setMailbox(string $mailbox): Mailbox
    {
        $this->mailbox = $mailbox;

        return $this;
    }

    /**
     * @return string
     */
    public function getMailbox(): string
    {
        return $this->mailbox;
    }


    /**
     * @param int $unread
     *
     * @return Mailbox
     */
    public function setUnread(int $unread): Mailbox
    {
        $this->unread = $unread;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnread(): int
    {
        return $this->unread;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Mailbox
     */
    public function setCreated(?\DateTime $created): Mailbox
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime|null $updated
     *
     * @return Mailbox
     */
    public function setUpdated(?\DateTime $updated): Mailbox
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}
