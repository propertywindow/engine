<?php declare(strict_types=1);

namespace PropertyAlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Property;

/**
 * Alert
 *
 * @ORM\Table(name="alert")
 * @ORM\Entity(repositoryClass="PropertyAlertBundle\Repository\AlertRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Alert
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
     * @ORM\ManyToOne(targetEntity="PropertyAlertBundle\Entity\Applicant")
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
     *
     * @ORM\Column(name="read", type="boolean")
     */
    private $read = true;

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
     * Set applicant
     *
     * @param Applicant $applicant
     *
     * @return Alert
     */
    public function setApplicant(Applicant $applicant = null)
    {
        $this->applicant = $applicant;

        return $this;
    }

    /**
     * Get applicant
     *
     * @return Applicant
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * Set property
     *
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
     * Get property
     *
     * @return \PropertyBundle\Entity\Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set read
     *
     * @param boolean $read
     *
     * @return Alert
     */
    public function setRead($read)
    {
        $this->read = $read;

        return $this;
    }

    /**
     * Get read
     *
     * @return bool
     */
    public function getRead()
    {
        return $this->read;
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
