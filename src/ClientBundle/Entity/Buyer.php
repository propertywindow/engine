<?php
declare(strict_types = 1);

namespace ClientBundle\Entity;

use AgentBundle\Entity\Solicitor;
use AppBundle\Entity\ContactAddress;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="buyer")
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\BuyerRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Buyer
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Solicitor")
     * @ORM\JoinColumn(name="solicitor_id", referencedColumnName="id")
     */
    private $solicitor;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ContactAddress")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

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
     * @param \AgentBundle\Entity\Solicitor $solicitor
     *
     * @return Buyer
     */
    public function setSolicitor(Solicitor $solicitor)
    {
        $this->solicitor = $solicitor;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\Solicitor
     */
    public function getSolicitor(): Solicitor
    {
        return $this->solicitor;
    }

    /**
     * @param string $firstName
     *
     * @return Buyer
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     *
     * @return Buyer
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param \AppBundle\Entity\ContactAddress $address
     *
     * @return Buyer
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
     * @param string $email
     *
     * @return Buyer
     */
    public function setEmail($email): self
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
     * @param string $phone
     *
     * @return Buyer
     */
    public function setPhone($phone): self
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
     * @param \DateTime|null $created
     *
     * @return Buyer
     */
    public function setCreated(?\DateTime $created): self
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
     * @return Buyer
     */
    public function setUpdated(?\DateTime $updated): Buyer
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
