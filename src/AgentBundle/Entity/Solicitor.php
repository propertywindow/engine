<?php declare(strict_types=1);

namespace AgentBundle\Entity;

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
     * @var int
     * @ORM\Column(name="agent_id", type="integer")
     */
    private $agentId;

    /**
     * @var int
     * @ORM\Column(name="agency_id", type="integer")
     */
    private $agencyId;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     * @ORM\Column(name="house_number", type="string", length=10)
     */
    private $houseNumber;

    /**
     * @var string
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $agentId
     *
     * @return Solicitor
     */
    public function setAgentId(int $agentId): Solicitor
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * @return int
     */
    public function getAgentId(): int
    {
        return $this->agentId;
    }

    /**
     * @param integer $agencyId
     *
     * @return Solicitor
     */
    public function setAgencyId(int $agencyId): Solicitor
    {
        $this->agencyId = $agencyId;

        return $this;
    }

    /**
     * @return int
     */
    public function getAgencyId(): int
    {
        return $this->agencyId;
    }

    /**
     * @param string $name
     *
     * @return Solicitor
     */
    public function setName(string $name): Solicitor
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
     * @param string $street
     *
     * @return Solicitor
     */
    public function setStreet(string $street): Solicitor
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $houseNumber
     *
     * @return Solicitor
     */
    public function setHouseNumber(string $houseNumber): Solicitor
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * @param string $postcode
     *
     * @return Solicitor
     */
    public function setPostcode(string $postcode): Solicitor
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * @param string $city
     *
     * @return Solicitor
     */
    public function setCity(string $city): Solicitor
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $country
     *
     * @return Solicitor
     */
    public function setCountry(string $country): Solicitor
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
