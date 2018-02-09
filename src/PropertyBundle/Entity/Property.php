<?php
declare(strict_types=1);

namespace PropertyBundle\Entity;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Client;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\PropertyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Property
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="property", cascade={"remove"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Kind", inversedBy="properties")
     * @ORM\JoinColumn(name="kind_id", referencedColumnName="id")
     */
    private $kind;

    /**
     * @ORM\ManyToOne(targetEntity="Terms")
     * @ORM\JoinColumn(name="terms_id", referencedColumnName="id")
     */
    private $terms;

    /**
     * @ORM\ManyToOne(targetEntity="SubType")
     * @ORM\JoinColumn(name="sub_type_id", referencedColumnName="id")
     */
    private $subType;

    /**
     * @ORM\OneToOne(targetEntity="Details", mappedBy="property")
     */
    private $details;

    /**
     * @var bool
     * @ORM\Column(name="online", type="boolean", options={"default": false})
     */
    private $online = false;

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
     * @ORM\Column(name="price", type="integer")
     */
    private $price = 0;

    /**
     * @var int
     * @ORM\Column(name="sold_price", type="integer", nullable=true)
     */
    private $soldPrice;

    /**
     * @var bool
     * @ORM\Column(name="espc", type="boolean", options={"default": false})
     */
    private $espc = false;

    /**
     * @var float
     * @ORM\Column(name="lat", type="float", length=20)
     */
    private $lat;

    /**
     * @var float
     * @ORM\Column(name="lng", type="float", length=20)
     */
    private $lng;

    /**
     * @var bool
     * @ORM\Column(name="archived", type="boolean", options={"default": false})
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
     * Constructor
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Gallery $image
     *
     * @return Property
     */
    public function addImage(Gallery $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * @param Gallery $image
     */
    public function removeImage(Gallery $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return Property
     */
    public function setAgent(Agent $agent): Property
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }


    /**
     * @param \AgentBundle\Entity\Client $client
     *
     * @return Property
     */
    public function setClient(Client $client): Property
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Kind $kind
     *
     * @return Property
     */
    public function setKind(Kind $kind): Property
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * @return Kind
     */
    public function getKind(): Kind
    {
        return $this->kind;
    }

    /**
     * @param Terms $terms
     *
     * @return Property
     */
    public function setTerms(Terms $terms): Property
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * @return Terms
     */
    public function getTerms(): Terms
    {
        return $this->terms;
    }

    /**
     * @param SubType $subType
     *
     * @return Property
     */
    public function setSubType(SubType $subType): Property
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * @return SubType
     */
    public function getSubType(): SubType
    {
        return $this->subType;
    }

    /**
     * @param Details $details
     *
     * @return Property
     */
    public function setDetails(Details $details = null): Property
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Details|null
     */
    public function getDetails(): ?Details
    {
        return $this->details;
    }

    /**
     * @param boolean $online
     *
     * @return Property
     */
    public function setOnline(bool $online): Property
    {
        $this->online = $online;

        return $this;
    }

    /**
     * @return bool
     */
    public function getOnline(): bool
    {
        return $this->online;
    }

    /**
     * @param string $street
     *
     * @return Property
     */
    public function setStreet(string $street): Property
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
     * @return Property
     */
    public function setHouseNumber(string $houseNumber): Property
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
     * @return Property
     */
    public function setPostcode(string $postcode): Property
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
     * @return Property
     */
    public function setCity(string $city): Property
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
     * @return Property
     */
    public function setCountry(string $country): Property
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
     * @param integer $price
     *
     * @return Property
     */
    public function setPrice(int $price): Property
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int|null $soldPrice
     *
     * @return Property
     */
    public function setSoldPrice(?int $soldPrice): Property
    {
        $this->soldPrice = $soldPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSoldPrice(): ?int
    {
        return $this->soldPrice;
    }

    /**
     * @param boolean $espc
     *
     * @return Property
     */
    public function setEspc(bool $espc): Property
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
     * @param float $lat
     *
     * @return Property
     */
    public function setLat(float $lat): Property
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lng
     *
     * @return Property
     */
    public function setLng(float $lng): Property
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @param boolean $archived
     *
     * @return Property
     */
    public function setArchived(bool $archived): Property
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

    /**
     * Get created
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get updated
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
