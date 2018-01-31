<?php
declare(strict_types=1);

namespace AlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Property;

/**
 * @ORM\Table(name="alert")
 * @ORM\Entity(repositoryClass="AlertBundle\Repository\AlertRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Alert
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AlertBundle\Entity\Applicant")
     * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id", nullable=true)
     */
    protected $applicant;


    /**
     * @ORM\ManyToOne(targetEntity="PropertyBundle\Entity\Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id", nullable=true)
     */
    protected $property;

    /**
     * @var bool
     * @ORM\Column(name="read", type="boolean")
     */
    private $read = true;

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
     * @param Applicant $applicant
     *
     * @return Alert
     */
    public function setApplicant(Applicant $applicant): Alert
    {
        $this->applicant = $applicant;

        return $this;
    }

    /**
     * @return Applicant
     */
    public function getApplicant(): Applicant
    {
        return $this->applicant;
    }

    /**
     * @param \PropertyBundle\Entity\Property $property
     *
     * @return Alert
     */
    public function setProperty(Property $property = null)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return \PropertyBundle\Entity\Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param boolean $read
     *
     * @return Alert
     */
    public function setRead(bool $read): Alert
    {
        $this->read = $read;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRead(): bool
    {
        return $this->read;
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
