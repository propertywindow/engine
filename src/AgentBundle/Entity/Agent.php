<?php
declare(strict_types=1);

namespace AgentBundle\Entity;

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
     * @var int
     * @ORM\Column(name="agent_user_id", type="integer", nullable=true)
     */
    private $userId;

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
     * @param int $userId
     *
     * @return Agent
     */
    public function setUserId(int $userId): Agent
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param string $office
     *
     * @return Agent
     */
    public function setOffice($office): Agent
    {
        $this->office = $office;

        return $this;
    }

    /**
     * @return string
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * @param string $phone
     *
     * @return Agent
     */
    public function setPhone($phone): Agent
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
     * @return Agent
     */
    public function setFax($fax): Agent
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
     * @param string $website
     *
     * @return Agent
     */
    public function setWebsite($website): Agent
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $logo
     *
     * @return Agent
     */
    public function setLogo($logo): Agent
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $street
     *
     * @return Agent
     */
    public function setStreet($street): Agent
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
     * @return Agent
     */
    public function setHouseNumber($houseNumber): Agent
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
     * @return Agent
     */
    public function setPostcode($postcode): Agent
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
     * @return Agent
     */
    public function setCity($city): Agent
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
     * @return Agent
     */
    public function setCountry($country): Agent
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
    public function getEspc(): bool
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
    public function getArchived(): bool
    {
        return $this->archived;
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
