<?php declare(strict_types=1);

namespace PropertyAlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="alert_application")
 * @ORM\Entity(repositoryClass="PropertyAlertBundle\Repository\ApplicationRepository")
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
     * @ORM\ManyToOne(targetEntity="PropertyAlertBundle\Entity\Applicant")
     * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id", nullable=true)
     */
    protected $applicant;

    /**
     * @var string
     *
     * @ORM\Column(name="kind", type="string", length=10)
     */
    private $kind;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

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
     * @var int
     *
     * @ORM\Column(name="sub_type", type="integer")
     */
    private $subType;

    /**
     * @var int
     *
     * @ORM\Column(name="rooms", type="integer")
     */
    private $rooms = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="terms", type="boolean")
     */
    private $terms = true;

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
     * @param string $kind
     *
     * @return Application
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
     * @param integer $subType
     *
     * @return Application
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
     * @param boolean $terms
     *
     * @return Application
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return bool
     */
    public function getTerms()
    {
        return $this->terms;
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
