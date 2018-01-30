<?php
declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="appointment")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\AppointmentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Appointment
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     * @ORM\Column(name="buyer_id", type="integer", nullable=true)
     */
    private $buyerId;

    /**
     * @var int
     * @ORM\Column(name="property_id", type="integer", nullable=true)
     */
    private $propertyId;

    /**
     * @var string
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="description", type="blob")
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $userId
     *
     * @return Appointment
     */
    public function setUserId(int $userId): Appointment
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $buyerId
     *
     * @return Appointment
     */
    public function setBuyerId($buyerId): Appointment
    {
        $this->buyerId = $buyerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getBuyerId()
    {
        return $this->buyerId;
    }

    /**
     * @param integer $propertyId
     *
     * @return Appointment
     */
    public function setPropertyId($propertyId): Appointment
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @param string $subject
     *
     * @return Appointment
     */
    public function setSubject($subject): Appointment
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $description
     *
     * @return Appointment
     */
    public function setDescription($description): Appointment
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DateTime $start
     *
     * @return Appointment
     */
    public function setStart($start): Appointment
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime $end
     *
     * @return Appointment
     */
    public function setEnd($end): Appointment
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
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
