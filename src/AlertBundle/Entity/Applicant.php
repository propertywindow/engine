<?php
declare(strict_types = 1);

namespace AlertBundle\Entity;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\AgentGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="alert_applicant")
 * @ORM\Entity(repositoryClass="AlertBundle\Repository\ApplicantRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Applicant
{
    /**
     * @var int
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var bool
     * @ORM\Column(name="protection", type="boolean")
     */
    private $protection = false;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=2)
     */
    private $country;

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

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
     * @param \AgentBundle\Entity\AgentGroup $agentGroup
     *
     * @return Applicant
     */
    public function setAgentGroup(AgentGroup $agentGroup): Applicant
    {
        $this->agentGroup = $agentGroup;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\AgentGroup
     */
    public function getAgentGroup(): AgentGroup
    {
        return $this->agentGroup;
    }

    /**
     * @param string $name
     *
     * @return Applicant
     */
    public function setName(string $name): Applicant
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $email
     *
     * @return Applicant
     */
    public function setEmail(string $email): Applicant
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $phone
     *
     * @return Applicant
     */
    public function setPhone($phone): Applicant
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param boolean $protection
     *
     * @return Applicant
     */
    public function setProtection(bool $protection): Applicant
    {
        $this->protection = $protection;

        return $this;
    }

    /**
     * @return bool
     */
    public function getProtection(): bool
    {
        return $this->protection;
    }

    /**
     * @param string $country
     *
     * @return Applicant
     */
    public function setCountry(string $country): Applicant
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param boolean $active
     *
     * @return Applicant
     */
    public function setActive(bool $active): Applicant
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
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
