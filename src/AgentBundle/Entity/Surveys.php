<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Property;

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
     * @ORM\ManyToOne(targetEntity="Surveyor")
     * @ORM\JoinColumn(name="surveyor_id", referencedColumnName="id")
     */
    private $surveyor;

    /**
     * @ORM\ManyToOne(targetEntity="Buyer")
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id")
     */
    private $buyer;

    /**
     * @ORM\OneToOne(targetEntity="PropertyBundle\Entity\Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property;

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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Surveyor $surveyor
     *
     * @return Surveys
     */
    public function setSurveyor(Surveyor $surveyor): Surveys
    {
        $this->surveyor = $surveyor;

        return $this;
    }

    /**
     * @return Surveyor
     */
    public function getSurveyor(): Surveyor
    {
        return $this->surveyor;
    }

    /**
     * @param Buyer $buyer
     *
     * @return Surveys
     */
    public function setBuyer(Buyer $buyer): Surveys
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
     * @param \PropertyBundle\Entity\Property $property
     *
     * @return Surveys
     */
    public function setProperty(Property $property): Surveys
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
     * @param \DateTime|null $created
     *
     * @return Surveys
     */
    public function setCreated(?\DateTime $created): Surveys
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
     * @return Surveys
     */
    public function setUpdated(?\DateTime $updated): Surveys
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
