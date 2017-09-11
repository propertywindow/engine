<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceGroupMap
 *
 * @ORM\Table(name="service_group_map")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ServiceGroupMapRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ServiceGroupMap
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceGroup")
     * @ORM\JoinColumn(name="service_group_id", referencedColumnName="id")
     */
    private $serviceGroup;

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
     * Set user
     *
     * @param User $user
     *
     * @return ServiceGroupMap
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set serviceGroup
     *
     * @param ServiceGroup
     *
     * @return ServiceGroupMap
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
