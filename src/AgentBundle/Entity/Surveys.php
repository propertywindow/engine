<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="surveys")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\SurveysRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Surveys
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
     * @ORM\Column(name="surveyor_id", type="integer")
     */
    private $surveyorId;

    /**
     * @var int
     * @ORM\Column(name="buyer_id", type="integer")
     */
    private $buyerId;

    /**
     * @var int
     * @ORM\Column(name="property_id", type="integer")
     */
    private $propertyId;

    /**
     * @var \DateTime
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     * @ORM\Column(name="notes", type="blob")
     */
    private $notes;

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
     * @param integer $surveyorId
     *
     * @return Surveys
     */
    public function setSurveyorId(int $surveyorId): Surveys
    {
        $this->surveyorId = $surveyorId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSurveyorId(): int
    {
        return $this->surveyorId;
    }

    /**
     * @param integer $buyerId
     *
     * @return Surveys
     */
    public function setBuyerId($buyerId): Surveys
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
     * @return Surveys
     */
    public function setPropertyId(int $propertyId): Surveys
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
     * @param \DateTime $datetime
     *
     * @return Surveys
     */
    public function setDatetime(\DateTime $datetime): Surveys
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    /**
     * @param string $notes
     *
     * @return Surveys
     */
    public function setNotes($notes): Surveys
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
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
