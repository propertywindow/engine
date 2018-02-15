<?php
declare(strict_types = 1);

namespace AgentBundle\Entity;

use AppBundle\Entity\ContactAddress;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="solicitor")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\SolicitorRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Solicitor
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="Agency")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     */
    private $agency;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ContactAddress")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     */
    private $address;

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
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

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
     * @param Agent $agent
     *
     * @return Solicitor
     */
    public function setAgent(Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @param Agency $agency
     *
     * @return Solicitor
     */
    public function setAgency(Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * @return Agency
     */
    public function getAgency(): Agency
    {
        return $this->agency;
    }

    /**
     * @param string $name
     *
     * @return Solicitor
     */
    public function setName(string $name): self
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
     * @param \AppBundle\Entity\ContactAddress $address
     *
     * @return Solicitor
     */
    public function setAddress(ContactAddress $address = null): self
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
     * @param string $phone
     *
     * @return Solicitor
     */
    public function setPhone($phone): Solicitor
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
     * @param string $fax
     *
     * @return Solicitor
     */
    public function setFax($fax): Solicitor
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $email
     *
     * @return Solicitor
     */
    public function setEmail($email): Solicitor
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Solicitor
     */
    public function setCreated(?\DateTime $created): Solicitor
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
     * @return Solicitor
     */
    public function setUpdated(?\DateTime $updated): Solicitor
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
