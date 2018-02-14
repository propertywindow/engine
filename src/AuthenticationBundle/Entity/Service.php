<?php
declare(strict_types = 1);

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ServiceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Service
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceGroup", inversedBy="services")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $serviceGroup;

    /**
     * @var string
     * @ORM\Column(name="function_name", type="string", length=255, nullable=true)
     */
    private $functionName;

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
     * @var bool
     * @ORM\Column(name="visible", type="boolean", options={"default": false})
     */
    private $visible = false;

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
     * @param ServiceGroup $serviceGroup
     *
     * @return Service
     */
    public function setServiceGroup(ServiceGroup $serviceGroup): Service
    {
        $this->serviceGroup = $serviceGroup;

        return $this;
    }

    /**
     * @return ServiceGroup
     */
    public function getServiceGroup(): ServiceGroup
    {
        return $this->serviceGroup;
    }

    /**
     * @param string|null $functionName
     *
     * @return Service
     */
    public function setFunctionName(?string $functionName): Service
    {
        $this->functionName = $functionName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFunctionName(): ?string
    {
        return $this->functionName;
    }

    /**
     * @param string $en
     *
     * @return Service
     */
    public function setEn(string $en): Service
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
     * @return Service
     */
    public function setNl(string $nl): Service
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
     * @return Service
     */
    public function setIcon(?string $icon): Service
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
     * @return Service
     */
    public function setUrl(?string $url): Service
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
     * @param boolean $visible
     *
     * @return Service
     */
    public function setVisible(bool $visible): Service
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return bool
     */
    public function getVisible(): bool
    {
        return $this->visible;
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
