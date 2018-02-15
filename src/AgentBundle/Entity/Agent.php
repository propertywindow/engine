<?php
declare(strict_types = 1);

namespace AgentBundle\Entity;

use AppBundle\Entity\ContactAddress;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agent")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\AgentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Agent
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AgentGroup")
     * @ORM\JoinColumn(name="agent_group_id", referencedColumnName="id")
     */
    private $agentGroup;

    /**
     * @ORM\OneToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ContactAddress")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="office", type="string", length=255)
     */
    private $office;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var int
     * @ORM\Column(name="property_limit", type="integer")
     */
    private $propertyLimit = 0;

    /**
     * @var bool
     * @ORM\Column(name="webprint", type="boolean")
     */
    private $webprint = false;

    /**
     * @var bool
     * @ORM\Column(name="ESPC", type="boolean")
     */
    private $espc = false;

    /**
     * @var bool
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = false;

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
     * @param AgentGroup $agentGroup
     *
     * @return Agent
     */
    public function setAgentGroup(AgentGroup $agentGroup): Agent
    {
        $this->agentGroup = $agentGroup;

        return $this;
    }

    /**
     * @return AgentGroup
     */
    public function getAgentGroup(): AgentGroup
    {
        return $this->agentGroup;
    }

    /**
     * @param \AuthenticationBundle\Entity\User $user
     *
     * @return Agent
     */
    public function setUser(User $user = null): Agent
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \AuthenticationBundle\Entity\User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param \AppBundle\Entity\ContactAddress $address
     *
     * @return Agent
     */
    public function setAddress(ContactAddress $address = null): Agent
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\ContactAddress|null
     */
    public function getAddress(): ?ContactAddress
    {
        return $this->address;
    }

    /**
     * @param string $office
     *
     * @return Agent
     */
    public function setOffice(string $office): Agent
    {
        $this->office = $office;

        return $this;
    }

    /**
     * @return string
     */
    public function getOffice(): string
    {
        return $this->office;
    }

    /**
     * @param string|null $phone
     *
     * @return Agent
     */
    public function setPhone(?string $phone): Agent
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $fax
     *
     * @return Agent
     */
    public function setFax(?string $fax): Agent
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFax(): ?string
    {
        return $this->fax;
    }

    /**
     * @param string $email
     *
     * @return Agent
     */
    public function setEmail(string $email): Agent
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
     * @param string|null $website
     *
     * @return Agent
     */
    public function setWebsite(?string $website): Agent
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $logo
     *
     * @return Agent
     */
    public function setLogo(?string $logo): Agent
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param int $propertyLimit
     *
     * @return Agent
     */
    public function setPropertyLimit(int $propertyLimit): Agent
    {
        $this->propertyLimit = $propertyLimit;

        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyLimit(): int
    {
        return $this->propertyLimit;
    }

    /**
     * @param bool $webprint
     *
     * @return Agent
     */
    public function setWebprint(bool $webprint): Agent
    {
        $this->webprint = $webprint;

        return $this;
    }

    /**
     * @return bool
     */
    public function getWebprint(): bool
    {
        return $this->webprint;
    }

    /**
     * @param boolean $espc
     *
     * @return Agent
     */
    public function setEspc(bool $espc): Agent
    {
        $this->espc = $espc;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEspc(): bool
    {
        return $this->espc;
    }

    /**
     * @param bool $archived
     *
     * @return Agent
     */
    public function setArchived(bool $archived): Agent
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->archived;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Agent
     */
    public function setCreated(?\DateTime $created): Agent
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
     * @param \DateTime|null $updated
     *
     * @return Agent
     */
    public function setUpdated(?\DateTime $updated): Agent
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
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
