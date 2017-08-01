<?php declare(strict_types=1);

namespace EmailAlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 *
 * @ORM\Table(name="email_alert")
 * @ORM\Entity(repositoryClass="EmailAlertBundle\Repository\AlertRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Alert
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
     * @ORM\Column(name="applicant_id", type="integer")
     */
    private $applicantId;

    /**
     * @var int
     *
     * @ORM\Column(name="agent_group_id", type="integer")
     */
    private $agentGroupId;

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
     * Set applicantId
     *
     * @param integer $applicantId
     *
     * @return Alert
     */
    public function setApplicantId($applicantId)
    {
        $this->applicantId = $applicantId;

        return $this;
    }

    /**
     * Get applicantId
     *
     * @return int
     */
    public function getApplicantId()
    {
        return $this->applicantId;
    }

    /**
     * Set agentGroupId
     *
     * @param integer $agentGroupId
     *
     * @return Alert
     */
    public function setAgentGroupId($agentGroupId)
    {
        $this->agentGroupId = $agentGroupId;

        return $this;
    }

    /**
     * Get agentGroupId
     *
     * @return int
     */
    public function getAgentGroupId()
    {
        return $this->agentGroupId;
    }

    /**
     * Set kind
     *
     * @param string $kind
     *
     * @return Alert
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
     * @return Alert
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
     * @return Alert
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
     * @return Alert
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
     * @return Alert
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
     * @return Alert
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
     * @return Alert
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
     * @return Alert
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
