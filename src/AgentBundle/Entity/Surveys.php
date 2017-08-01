<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Surveys
 *
 * @ORM\Table(name="surveys")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\SurveysRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Surveys
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
     * @ORM\Column(name="surveyor_id", type="integer")
     */
    private $surveyorId;

    /**
     * @var int
     *
     * @ORM\Column(name="buyer_id", type="integer")
     */
    private $buyerId;

    /**
     * @var int
     *
     * @ORM\Column(name="property_id", type="integer")
     */
    private $propertyId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="blob")
     */
    private $notes;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

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
     * Set surveyorId
     *
     * @param integer $surveyorId
     *
     * @return Surveys
     */
    public function setSurveyorId($surveyorId)
    {
        $this->surveyorId = $surveyorId;

        return $this;
    }

    /**
     * Get surveyorId
     *
     * @return int
     */
    public function getSurveyorId()
    {
        return $this->surveyorId;
    }

    /**
     * Set buyerId
     *
     * @param integer $buyerId
     *
     * @return Surveys
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
     * Set propertyId
     *
     * @param integer $propertyId
     *
     * @return Surveys
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
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Surveys
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Surveys
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}
