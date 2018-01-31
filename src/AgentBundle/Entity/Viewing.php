<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="viewing")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\ViewingRepository")
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
     * @var int
     * @ORM\Column(name="property_id", type="integer")
     */
    private $propertyId;

    /**
     * @var int
     * @ORM\Column(name="buyer_id", type="integer")
     */
    private $buyerId;

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
     * @var int
     * @ORM\Column(name="staff", type="integer")
     */
    private $staff;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $propertyId
     *
     * @return Viewing
     */
    public function setPropertyId(int $propertyId): Viewing
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyId(): int
    {
        return $this->propertyId;
    }

    /**
     * @param integer $buyerId
     *
     * @return Viewing
     */
    public function setBuyerId($buyerId): Viewing
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
     * @param integer $staff
     *
     * @return Viewing
     */
    public function setStaff($staff): Viewing
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * @return int
     */
    public function getStaff()
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
