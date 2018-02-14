<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="service_group")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ServiceGroupRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ServiceGroup
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="serviceGroup", cascade={"remove"})
     */
    private $services;

    /**
     * @var string
     * @ORM\Column(name="en", type="string", length=255)
     */
    private $en;

    /**
     * @var string
     * @ORM\Column(name="nl", type="string", length=255)
     */
    private $nl;

    /**
     * @var string
     * @ORM\Column(name="icon", type="string", nullable=true)
     */
    private $icon;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

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
     * Constructor
     */
    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Service $service
     *
     * @return ServiceGroup
     */
    public function addService(Service $service): ServiceGroup
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * @param Service $service
     */
    public function removeService(Service $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * @return Collection
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    /**
     * @param string $en
     *
     * @return ServiceGroup
     */
    public function setEn(string $en): ServiceGroup
    {
        $this->en = $en;

        return $this;
    }

    /**
     * @return string
     */
    public function getEn(): string
    {
        return $this->en;
    }

    /**
     * @param string $nl
     *
     * @return ServiceGroup
     */
    public function setNl(string $nl): ServiceGroup
    {
        $this->nl = $nl;

        return $this;
    }

    /**
     * @return string
     */
    public function getNl(): string
    {
        return $this->nl;
    }

    /**
     * @param string|null $icon
     *
     * @return ServiceGroup
     */
    public function setIcon(?string $icon): ServiceGroup
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $url
     *
     * @return ServiceGroup
     */
    public function setUrl(?string $url): ServiceGroup
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
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
