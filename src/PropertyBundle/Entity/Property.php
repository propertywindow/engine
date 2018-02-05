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
     * @var string
     * @ORM\Column(name="lat", type="string", length=20)
     */
    private $lat;

    /**
     * @var string
     * @ORM\Column(name="lng", type="string", length=20)
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
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return Property
     */
    public function setAgent(Agent $agent = null): Property
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
    public function setClient(Client $client = null): Property
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
     * Set kind
     *
     * @param Kind $kind
     *
     * @return Property
     */
    public function setKind(Kind $kind = null)
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
    public function setTerms(Terms $terms = null)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * @return Terms
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param SubType $subType
     *
     * @return Property
     */
    public function setSubType(SubType $subType = null)
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * @return SubType
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * @param Details $details
     *
     * @return Property
     */
    public function setDetails(Details $details = null)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Details
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param boolean $online
     *
     * @return Property
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * @return bool
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * @param string $street
     *
     * @return Property
     */
    public function setStreet($street)
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
     * @return Property
     */
    public function setHouseNumber($houseNumber)
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
     * @return Property
     */
    public function setPostcode($postcode)
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
     * @return Property
     */
    public function setCity($city)
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
     * @return Property
     */
    public function setCountry($country)
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
     * @param integer $price
     *
     * @return Property
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $soldPrice
     *
     * @return Property
     */
    public function setSoldPrice($soldPrice)
    {
        $this->soldPrice = $soldPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getSoldPrice()
    {
        return $this->soldPrice;
    }

    /**
     * @param boolean $espc
     *
     * @return Property
     */
    public function setEspc(bool $espc)
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
     * @param string $lat
     *
     * @return Property
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lng
     *
     * @return Property
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param boolean $archived
     *
     * @return Property
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return bool
     */
    public function getArchived()
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
