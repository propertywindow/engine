<?php
declare(strict_types=1);

namespace LogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Property;

/**
 * @ORM\Table(name="log_traffic")
 * @ORM\Entity(repositoryClass="LogBundle\Repository\TrafficRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Traffic
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="PropertyBundle\Entity\Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property;

    /**
     * @var string
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var string
     * @ORM\Column(name="browser", type="string", length=255)
     */
    private $browser;

    /**
     * @var string
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     * @ORM\Column(name="referrer", type="string", length=255, nullable=true)
     */
    private $referrer;

    /**
     * @var \DateTime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;


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
     * @return Traffic
     */
    public function setProperty(Property $property): Traffic
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
     * @param string $ip
     *
     * @return Traffic
     */
    public function setIp(string $ip): Traffic
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $browser
     *
     * @return Traffic
     */
    public function setBrowser(string $browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get browser
     * @return string
     */
    public function getBrowser(): string
    {
        return $this->browser;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Traffic
     */
    public function setLocation(string $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string|null $referrer
     *
     * @return Traffic
     */
    public function setReferrer(?string $referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferrer(): ?string
    {
        return $this->referrer;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Traffic
     */
    public function setCreated(?\DateTime $created): Traffic
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
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }
}
