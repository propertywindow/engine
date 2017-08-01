<?php declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 *
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\PropertyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Property
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
     * @var int
     *
     * @ORM\Column(name="agentId", type="integer")
     */
    private $agentId;

    /**
     * @var string
     *
     * @ORM\Column(name="kind", type="string", length=10)
     */
    private $kind;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="sub_type", type="integer")
     */
    private $subType;

    /**
     * @var bool
     *
     * @ORM\Column(name="online", type="boolean")
     */
    private $online;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="house_number", type="string", length=5)
     */
    private $houseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="espc", type="boolean")
     */
    private $espc;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=20)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=20)
     */
    private $lng;

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean", options={"default": false})
     */
    private $archived;

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
     * Set agentId
     *
     * @param integer $agentId
     *
     * @return Property
     */
    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * Get agentId
     *
     * @return int
     */
    public function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * Set kind
     *
     * @param string $kind
     *
     * @return Property
     */
    public function setKind($kind)
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * Get kind
     *
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Property
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set subType
     *
     * @param integer $subType
     *
     * @return Property
     */
    public function setSubType($subType)
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * Get subType
     *
     * @return int
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * Set online
     *
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
     * Get online
     *
     * @return bool
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set street
     *
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
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
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
     * Get houseNumber
     *
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set postcode
     *
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
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city
     *
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
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
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
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set price
     *
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
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set espc
     *
     * @param boolean $espc
     *
     * @return Property
     */
    public function setEspc($espc)
    {
        $this->espc = $espc;

        return $this;
    }

    /**
     * Get espc
     *
     * @return bool
     */
    public function getEspc()
    {
        return $this->espc;
    }

    /**
     * Set lat
     *
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
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
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
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set archived
     *
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
     * Get archived
     *
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
}
