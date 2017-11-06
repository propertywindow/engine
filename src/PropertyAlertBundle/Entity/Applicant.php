<?php declare(strict_types=1);

namespace PropertyAlertBundle\Entity;

use AgentBundle\Entity\AgentGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Applicant
 *
 * @ORM\Table(name="alert_applicant")
 * @ORM\Entity(repositoryClass="PropertyAlertBundle\Repository\ApplicantRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Applicant
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
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\AgentGroup")
     * @ORM\JoinColumn(name="agent_group_id", referencedColumnName="id", nullable=true)
     */
    protected $agentGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;

    /**
     * @var bool
     *
     * @ORM\Column(name="protection", type="boolean")
     */
    private $protection = false;

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
     * Set agentGroup
     *
     * @param \AgentBundle\Entity\AgentGroup $agentGroup
     *
     * @return Applicant
     */
    public function setAgentGroup(AgentGroup $agentGroup)
    {
        $this->agentGroup = $agentGroup;

        return $this;
    }

    /**
     * Get agentGroup
     *
     * @return \AgentBundle\Entity\AgentGroup
     */
    public function getAgentGroup()
    {
        return $this->agentGroup;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Applicant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Applicant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Applicant
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set protection
     *
     * @param boolean $protection
     *
     * @return Applicant
     */
    public function setProtection($protection)
    {
        $this->protection = $protection;

        return $this;
    }

    /**
     * Get protection
     *
     * @return bool
     */
    public function getProtection()
    {
        return $this->protection;
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
