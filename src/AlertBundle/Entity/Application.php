<?php declare(strict_types=1);

namespace AlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;

/**
 * Application
 *
 * @ORM\Table(name="alert_application")
 * @ORM\Entity(repositoryClass="AlertBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Application
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
     * @ORM\ManyToOne(targetEntity="AlertBundle\Entity\Applicant")
     * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id", nullable=true)
     */
    protected $applicant;

    /**
     * @ORM\ManyToOne(targetEntity="PropertyBundle\Entity\Kind")
     * @ORM\JoinColumn(name="kind_id", referencedColumnName="id", nullable=true)
     */
    protected $kind;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=2)
     */
    private $country;

    /**
     * @var int
     *
     * @ORM\Column(name="distance", type="integer")
     */
    private $distance = 10;

    /**
     * @var int
     *
     * @ORM\Column(name="min_price", type="integer")
     */
    private $minPrice = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="max_price", type="integer")
     */
    private $maxPrice = 100000;

    /**
     * @ORM\ManyToOne(targetEntity="PropertyBundle\Entity\SubType")
     * @ORM\JoinColumn(name="sub_type_id", referencedColumnName="id", nullable=true)
     */
    protected $subType;

    /**
     * @var int
     *
     * @ORM\Column(name="rooms", type="integer")
     */
    private $rooms = 0;

    /**
     * @ORM\ManyToOne(targetEntity="PropertyBundle\Entity\Terms")
     * @ORM\JoinColumn(name="terms_id", referencedColumnName="id", nullable=true)
     */
    protected $terms;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

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
     * Set applicant
     *
     * @param Applicant $applicant
     *
     * @return Application
     */
    public function setApplicant(Applicant $applicant = null)
    {
        $this->applicant = $applicant;

        return $this;
    }

    /**
     * Get applicant
     *
     * @return Applicant
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * Set kind
     *
     * @param \PropertyBundle\Entity\Kind $kind
     *
     * @return Application
     */
    public function setKind(Kind $kind = null)
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * Get kind
     *
     * @return Applicant
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Application
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
     * Set country
     *
     * @param string $country
     *
     * @return Application
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
     * Set distance
     *
     * @param integer $distance
     *
     * @return Application
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set minPrice
     *
     * @param integer $minPrice
     *
     * @return Application
     */
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * Get minPrice
     *
     * @return int
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Set maxPrice
     *
     * @param integer $maxPrice
     *
     * @return Application
     */
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get maxPrice
     *
     * @return int
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set subType
     *
     * @param \PropertyBundle\Entity\SubType $subType
     *
     * @return Application
     */
    public function setSubType(SubType $subType = null)
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * Get subType
     *
     * @return Applicant
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return Application
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return int
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set terms
     *
     * @param \PropertyBundle\Entity\Terms $terms
     *
     * @return Application
     */
    public function setTerms(Terms $terms = null)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return Applicant
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Application
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}
