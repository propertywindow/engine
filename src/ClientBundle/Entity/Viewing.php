<?php
declare(strict_types = 1);

namespace ClientBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Property;

/**
 * @ORM\Table(name="viewing")
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ViewingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Viewing
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="PropertyBundle\Entity\Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property;

    /**
     * @ORM\ManyToOne(targetEntity="Buyer")
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id")
     */
    private $buyer;

    /**
     * @var bool
     * @ORM\Column(name="open_viewing", type="boolean")
     */
    private $openViewing;

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
     * @var bool
     * @ORM\Column(name="weekly", type="boolean")
     */
    private $weekly;

    /**
     * @var string
     * @ORM\Column(name="feedback", type="string", length=255)
     */
    private $feedback;

    /**
     * @ORM\OneToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="staff_id", referencedColumnName="id")
     */
    protected $staff;

    /**
     * @var bool
     * @ORM\Column(name="confirmation", type="boolean")
     */
    private $confirmation;

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
     * @param \PropertyBundle\Entity\Property $property
     *
     * @return Viewing
     */
    public function setProperty(Property $property): Viewing
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
     * @param Buyer $buyer
     *
     * @return Viewing
     */
    public function setBuyer(Buyer $buyer): Viewing
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * @return Buyer
     */
    public function getBuyer(): Buyer
    {
        return $this->buyer;
    }

    /**
     * @param boolean $openViewing
     *
     * @return Viewing
     */
    public function setOpenViewing(bool $openViewing): Viewing
    {
        $this->openViewing = $openViewing;

        return $this;
    }

    /**
     * @return bool
     */
    public function getOpenViewing(): bool
    {
        return $this->openViewing;
    }

    /**
     * @param \DateTime $start
     *
     * @return Viewing
     */
    public function setStart($start): Viewing
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
     * @return Viewing
     */
    public function setEnd($end): Viewing
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
     * @param boolean $weekly
     *
     * @return Viewing
     */
    public function setWeekly(bool $weekly): Viewing
    {
        $this->weekly = $weekly;

        return $this;
    }

    /**
     * @return bool
     */
    public function getWeekly(): bool
    {
        return $this->weekly;
    }

    /**
     * @param string $feedback
     *
     * @return Viewing
     */
    public function setFeedback($feedback): Viewing
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param \AuthenticationBundle\Entity\User $staff
     *
     * @return Viewing
     */
    public function setStaff(User $staff): Viewing
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * @return \AuthenticationBundle\Entity\User
     */
    public function getStaff(): User
    {
        return $this->staff;
    }

    /**
     * @param boolean $confirmation
     *
     * @return Viewing
     */
    public function setConfirmation(bool $confirmation): Viewing
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * @return bool
     */
    public function getConfirmation(): bool
    {
        return $this->confirmation;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Viewing
     */
    public function setCreated(?\DateTime $created): Viewing
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
     * @return Viewing
     */
    public function setUpdated(?\DateTime $updated): Viewing
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
