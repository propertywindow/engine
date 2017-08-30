<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceGroupTemplate
 *
 * @ORM\Table(name="service_group_template")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ServiceGroupTemplateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ServiceGroupTemplate
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
     * @ORM\ManyToOne(targetEntity="ServiceGroup", inversedBy="groupTemplates")
     * @ORM\JoinColumn(name="service_group_id", referencedColumnName="id")
     */
    private $serviceGroup;

    /**
     * @ORM\ManyToOne(targetEntity="UserType", inversedBy="serviceGroupTemplates")
     * @ORM\JoinColumn(name="user_type_id", referencedColumnName="id")
     */
    private $userType;

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
     * Set serviceGroup
     *
     * @param ServiceGroup
     *
     * @return ServiceGroupTemplate
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
     * Set userType
     *
     * @param userType
     *
     * @return ServiceGroupTemplate
     */
    public function setUserType(UserType $userType = null)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return userType
     */
    public function getUserType()
    {
        return $this->userType;
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
