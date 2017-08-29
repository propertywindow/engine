<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ServiceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Service
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
     * @ORM\OneToMany(targetEntity="ServiceTemplates", mappedBy="service")
     */
    private $templates;


    /**
     * @ORM\ManyToOne(targetEntity="ServiceGroup", inversedBy="services")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $serviceGroup;

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
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", options={"default": false})
     */
    private $visible = false;

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
        $this->templates = new ArrayCollection();
    }

    /**
     * Add template
     *
     * @param ServiceTemplates $templates
     *
     * @return Service
     */
    public function addTemplate(ServiceTemplates $templates)
    {
        $this->templates[] = $templates;

        return $this;
    }

    /**
     * Remove template
     *
     * @param ServiceTemplates $template
     */
    public function removeTemplate(ServiceTemplates $template)
    {
        $this->templates->removeElement($template);
    }

    /**
     * Get templates
     *
     * @return Collection
     */
    public function getTemplates()
    {
        return $this->templates;
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
     * Set serviceGroup
     *
     * @param ServiceGroup $serviceGroup
     *
     * @return Service
     */
    public function setServiceGroup(ServiceGroup $serviceGroup = null)
    {
        $this->serviceGroup = $serviceGroup;

        return $this;
    }

    /**
     * Get serviceGroup
     *
     * @return ServiceGroup
     */
    public function getServiceGroup()
    {
        return $this->serviceGroup;
    }

    /**
     * Set en
     *
     * @param string $en
     *
     * @return Service
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
     * @return Service
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
     * @return Service
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Service
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
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
