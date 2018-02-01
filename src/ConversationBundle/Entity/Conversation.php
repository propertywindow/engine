<?php declare(strict_types=1);

namespace ConversationBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\ConversationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Conversation
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var int
     * @ORM\Column(name="unique_id", type="integer")
     */
    private $uniqueId;

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
     * @param \AuthenticationBundle\Entity\User $author
     *
     * @return Conversation
     */
    public function setAuthor(User $author): Conversation
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
     * @return Conversation
     */
    public function setRecipient(User $recipient): Conversation
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
     * @param integer $uniqueId
     *
     * @return Conversation
     */
    public function setUniqueId(int $uniqueId)
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUniqueId(): int
    {
        return $this->uniqueId;
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
