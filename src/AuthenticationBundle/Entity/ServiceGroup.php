<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceGroup
 *
 * @ORM\Table(name="service_group")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ServiceGroupRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ServiceGroup
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
     * @ORM\OneToMany(targetEntity="ServiceGroupTemplates", mappedBy="serviceGroup")
     */
    private $groupTemplates;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="serviceGroup")
     */
    private $services;

    /**
     * @var string
     *
     * @ORM\Column(name="en", type="string", length=255)
     */
    private $en;

    /**
     * @var string
     *
     * @ORM\Column(name="nl", type="string", length=255)
     */
    private $nl;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string")
     */
    private $icon;

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
     * Constructor
     */
    public function __construct()
    {
        $this->groupTemplates = new ArrayCollection();
        $this->services       = new ArrayCollection();
    }

    /**
     * Add groupTemplate
     *
     * @param ServiceGroupTemplates $groupTemplates
     *
     * @return ServiceGroup
     */
    public function addGroupTemplate(ServiceGroupTemplates $groupTemplates)
    {
        $this->groupTemplates[] = $groupTemplates;

        return $this;
    }

    /**
     * Remove groupTemplate
     *
     * @param ServiceGroupTemplates $groupTemplate
     */
    public function removeGroupTemplate(ServiceGroupTemplates $groupTemplate)
    {
        $this->groupTemplates->removeElement($groupTemplate);
    }

    /**
     * Get groupTemplates
     *
     * @return Collection
     */
    public function getGroupTemplates()
    {
        return $this->groupTemplates;
    }


    /**
     * Add service
     *
     * @param Service $services
     *
     * @return ServiceGroup
     */
    public function addService(Service $services)
    {
        $this->services[] = $services;

        return $this;
    }

    /**
     * Remove service
     *
     * @param Service $service
     */
    public function removeService(Service $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * Get services
     *
     * @return Collection
     */
    public function getServices()
    {
        return $this->services;
    }


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
     * Set en
     *
     * @param string $en
     *
     * @return ServiceGroup
     */
    public function setEn($en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set nl
     *
     * @param string $nl
     *
     * @return ServiceGroup
     */
    public function setNl($nl)
    {
        $this->nl = $nl;

        return $this;
    }

    /**
     * Get nl
     *
     * @return string
     */
    public function getNl()
    {
        return $this->nl;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return ServiceGroup
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
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
