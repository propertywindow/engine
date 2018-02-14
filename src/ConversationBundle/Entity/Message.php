<?php
declare(strict_types = 1);

namespace ConversationBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="conversation_message")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\MessageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Message
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ConversationBundle\Entity\Conversation")
     * @ORM\JoinColumn(name="conversation_id", referencedColumnName="id")
     */
    private $conversation;

    /**
     * @ORM\ManyToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="recipient", referencedColumnName="id")
     */
    private $recipient;

    /**
     * @var string
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var bool
     * @ORM\Column(name="seen", type="boolean", options={"default": false})
     */
    private $seen = false;

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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Conversation $conversation
     *
     * @return Message
     */
    public function setConversation(Conversation $conversation): Message
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * @return Conversation
     */
    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    /**
     * @param \AuthenticationBundle\Entity\User $author
     *
     * @return Message
     */
    public function setAuthor(User $author): Message
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return \AuthenticationBundle\Entity\User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param \AuthenticationBundle\Entity\User $recipient
     *
     * @return Message
     */
    public function setRecipient(User $recipient): Message
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return \AuthenticationBundle\Entity\User
     */
    public function getRecipient(): User
    {
        return $this->recipient;
    }

    /**
     * @param string $message
     *
     * @return Message
     */
    public function setMessage(string $message): Message
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string|null $type
     *
     * @return Message
     */
    public function setType(?string $type): Message
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param boolean $seen
     *
     * @return Message
     */
    public function setSeen(bool $seen): Message
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSeen(): bool
    {
        return $this->seen;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Message
     */
    public function setCreated(?\DateTime $created): Message
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
     * @return Message
     */
    public function setUpdated(?\DateTime $updated): Message
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
