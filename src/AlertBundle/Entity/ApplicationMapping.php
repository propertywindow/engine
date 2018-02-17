<?php
declare(strict_types = 1);

namespace AlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Property;

/**
 * @ORM\Table(name="alert_application_mapping")
 * @ORM\Entity(repositoryClass="AlertBundle\Repository\ApplicationMappingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ApplicationMapping
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AlertBundle\Entity\Application")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    protected $application;

    /**
     * @ORM\OneToOne(targetEntity="PropertyBundle\Entity\Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property;

    /**
     * @var float
     * @ORM\Column(name="distance", type="float")
     */
    private $distance;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Application $application
     *
     * @return ApplicationMapping
     */
    public function setApplication(Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @param \PropertyBundle\Entity\Property $property
     *
     * @return ApplicationMapping
     */
    public function setProperty(Property $property): self
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
     * @param float $distance
     *
     * @return ApplicationMapping
     */
    public function setDistance(float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }
}
