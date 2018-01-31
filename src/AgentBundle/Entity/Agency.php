<?php
declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agency")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\AgencyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Agency
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
     * @ORM\Column(name="email", type="string", length=255)
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
     * @param int $agentId
     *
     * @return Agency
     */
    public function setAgentId(int $agentId): Agency
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
     * @param string $name
     *
     * @return Agency
     */
    public function setName($name): Agency
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $street
     *
     * @return Agency
     */
    public function setStreet($street): Agency
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $houseNumber
     *
     * @return Agency
     */
    public function setHouseNumber($houseNumber): Agency
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * @param string $postcode
     *
     * @return Agency
     */
    public function setPostcode($postcode): Agency
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $city
     *
     * @return Agency
     */
    public function setCity($city): Agency
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $country
     *
     * @return Agency
     */
    public function setCountry($country): Agency
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $phone
     *
     * @return Agency
     */
    public function setPhone($phone): Agency
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
     * @return Agency
     */
    public function setFax($fax): Agency
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
     * @return Agency
     */
    public function setEmail(string $email): Agency
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
