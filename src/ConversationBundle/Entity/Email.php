<?php
declare(strict_types=1);

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\EmailRepository")
 */
class Email
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
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="from", type="string", length=255)
     */
    private $from;


    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @param int $id
     *
     * @return Email
     */
    public function setId(int $id): Email
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $subject
     *
     * @return Email
     */
    public function setSubject(string $subject): Email
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $from
     *
     * @return Email
     */
    public function setFrom(string $from): Email
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param \DateTime $date
     *
     * @return Email
     */
    public function setDate(\DateTime $date): Email
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param string $message
     *
     * @return Email
     */
    public function setMessage(string $message): Email
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
}
