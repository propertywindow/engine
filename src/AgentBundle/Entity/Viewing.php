<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viewing
 *
 * @ORM\Table(name="viewing")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\ViewingRepository")
 */
class Viewing
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
     * @var int
     *
     * @ORM\Column(name="property_id", type="integer")
     */
    private $propertyId;

    /**
     * @var int
     *
     * @ORM\Column(name="buyer_id", type="integer")
     */
    private $buyerId;

    /**
     * @var bool
     *
     * @ORM\Column(name="open_viewing", type="boolean")
     */
    private $openViewing;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * @var bool
     *
     * @ORM\Column(name="weekly", type="boolean")
     */
    private $weekly;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="string", length=255)
     */
    private $feedback;

    /**
     * @var int
     *
     * @ORM\Column(name="staff", type="integer")
     */
    private $staff;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmation", type="boolean")
     */
    private $confirmation;


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
     * Set propertyId
     *
     * @param integer $propertyId
     *
     * @return Viewing
     */
    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * Get propertyId
     *
     * @return int
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Set buyerId
     *
     * @param integer $buyerId
     *
     * @return Viewing
     */
    public function setBuyerId($buyerId)
    {
        $this->buyerId = $buyerId;

        return $this;
    }

    /**
     * Get buyerId
     *
     * @return int
     */
    public function getBuyerId()
    {
        return $this->buyerId;
    }

    /**
     * Set openViewing
     *
     * @param boolean $openViewing
     *
     * @return Viewing
     */
    public function setOpenViewing($openViewing)
    {
        $this->openViewing = $openViewing;

        return $this;
    }

    /**
     * Get openViewing
     *
     * @return bool
     */
    public function getOpenViewing()
    {
        return $this->openViewing;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Viewing
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Viewing
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set weekly
     *
     * @param boolean $weekly
     *
     * @return Viewing
     */
    public function setWeekly($weekly)
    {
        $this->weekly = $weekly;

        return $this;
    }

    /**
     * Get weekly
     *
     * @return bool
     */
    public function getWeekly()
    {
        return $this->weekly;
    }

    /**
     * Set feedback
     *
     * @param string $feedback
     *
     * @return Viewing
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Get feedback
     *
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * Set staff
     *
     * @param integer $staff
     *
     * @return Viewing
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * Get staff
     *
     * @return int
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * Set confirmation
     *
     * @param boolean $confirmation
     *
     * @return Viewing
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return bool
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }
}
