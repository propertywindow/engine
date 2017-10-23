<?php declare(strict_types=1);

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mailbox
 *
 * @ORM\Table(name="mailbox")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\MailboxRepository")
 */
class Mailbox
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mailbox", type="string", length=255)
     */
    private $mailbox;

    /**
     * @var int
     *
     * @ORM\Column(name="unread", type="integer")
     */
    private $unread = 0;



    /**
     * Set id
     *
     * @param int $id
     *
     * @return Mailbox
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Mailbox
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mailbox
     *
     * @param string $mailbox
     *
     * @return Mailbox
     */
    public function setMailbox($mailbox)
    {
        $this->mailbox = $mailbox;

        return $this;
    }

    /**
     * Get mailbox
     *
     * @return string
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }


    /**
     * Set unread
     *
     * @param int $unread
     *
     * @return Mailbox
     */
    public function setUnread($unread)
    {
        $this->unread = $unread;

        return $this;
    }

    /**
     * Get unread
     *
     * @return int
     */
    public function getUnread()
    {
        return $this->unread;
    }
}
