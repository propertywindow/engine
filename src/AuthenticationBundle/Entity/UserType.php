<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserType
 *
 * @ORM\Table(name="user_type")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\UserTypeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class UserType
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
     * @ORM\OneToMany(targetEntity="ServiceTemplate", mappedBy="userType")
     */
    private $serviceTemplates;

    /**
     * @ORM\OneToMany(targetEntity="ServiceGroupTemplate", mappedBy="userType")
     */
    private $serviceGroupTemplates;

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
        $this->serviceTemplates = new ArrayCollection();
        $this->serviceGroupTemplates = new ArrayCollection();
    }

    /**
     * Add serviceTemplate
     *
     * @param ServiceTemplate $serviceTemplates
     *
     * @return UserType
     */
    public function addServiceTemplate(ServiceTemplate $serviceTemplates)
    {
        $this->serviceTemplates[] = $serviceTemplates;

        return $this;
    }

    /**
     * Remove serviceTemplates
     *
     * @param ServiceTemplate $serviceTemplate
     */
    public function removeServiceTemplate(ServiceTemplate $serviceTemplate)
    {
        $this->serviceTemplates->removeElement($serviceTemplate);
    }

    /**
     * Get serviceTemplates
     *
     * @return Collection
     */
    public function getServiceTemplates()
    {
        return $this->serviceTemplates;
    }

    /**
     * Add serviceGroupTemplate
     *
     * @param ServiceGroupTemplate $serviceGroupTemplates
     *
     * @return UserType
     */
    public function addServiceGroupTemplate(ServiceGroupTemplate $serviceGroupTemplates)
    {
        $this->serviceGroupTemplates[] = $serviceGroupTemplates;

        return $this;
    }

    /**
     * Remove serviceGroupTemplates
     *
     * @param ServiceGroupTemplate $serviceGroupTemplate
     */
    public function removeServiceGroupTemplate(ServiceGroupTemplate $serviceGroupTemplate)
    {
        $this->serviceGroupTemplates->removeElement($serviceGroupTemplate);
    }

    /**
     * Get serviceGroupTemplates
     *
     * @return Collection
     */
    public function getServiceGroupTemplates()
    {
        return $this->serviceGroupTemplates;
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
     * @return UserType
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
     * @return UserType
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
