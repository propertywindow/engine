<?php
declare(strict_types = 1);

namespace AppointmentBundle\Entity;

use AuthenticationBundle\Entity\User;
use ClientBundle\Entity\Buyer;
use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Property;

/**
 * @ORM\Table(name="appointment")
 * @ORM\Entity(repositoryClass="AppointmentBundle\Repository\AppointmentRepository")
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
     * @ORM\OneToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Buyer")
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id")
     */
    private $buyer;

    /**
     * @ORM\OneToOne(targetEntity="PropertyBundle\Entity\Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property;

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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param \AuthenticationBundle\Entity\User $user
     *
     * @return Appointment
     */
    public function setUser(User $user): Appointment
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \AuthenticationBundle\Entity\User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param \ClientBundle\Entity\Buyer $buyer
     *
     * @return Appointment
     */
    public function setBuyer(Buyer $buyer): Appointment
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * @return \ClientBundle\Entity\Buyer
     */
    public function getBuyer(): Buyer
    {
        return $this->buyer;
    }

    /**
     * @param \PropertyBundle\Entity\Property $property
     *
     * @return Appointment
     */
    public function setProperty(Property $property): Appointment
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return \PropertyBundle\Entity\Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }

    /**
     * @param string $subject
     *
     * @return Appointment
     */
    public function setSubject(string $subject): Appointment
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
     * @param string $description
     *
     * @return Appointment
     */
    public function setDescription(string $description): Appointment
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param \DateTime $start
     *
     * @return Appointment
     */
    public function setStart(\DateTime $start): Appointment
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * @param \DateTime $end
     *
     * @return Appointment
     */
    public function setEnd(\DateTime $end): Appointment
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Appointment
     */
    public function setCreated(?\DateTime $created): Appointment
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
     * @return Appointment
     */
    public function setUpdated(?\DateTime $updated): Appointment
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
