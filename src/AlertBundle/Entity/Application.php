<?php
declare(strict_types = 1);

namespace AlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;

/**
 * @ORM\Table(name="alert_application")
 * @ORM\Entity(repositoryClass="AlertBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Application
{
    /**
     * @var int
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
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=2)
     */
    private $country;

    /**
     * @var int
     * @ORM\Column(name="distance", type="integer")
     */
    private $distance = 10;

    /**
     * @var int
     * @ORM\Column(name="min_price", type="integer")
     */
    private $minPrice = 0;

    /**
     * @var int
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
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

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
     * @param Applicant $applicant
     *
     * @return Application
     */
    public function setApplicant(Applicant $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }

    /**
     * @return Applicant
     */
    public function getApplicant(): Applicant
    {
        return $this->applicant;
    }

    /**
     * @param \PropertyBundle\Entity\Kind $kind
     *
     * @return Application
     */
    public function setKind(Kind $kind = null): self
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
     * @param string $postcode
     *
     * @return Application
     */
    public function setPostcode(string $postcode): self
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
     * @param string $country
     *
     * @return Application
     */
    public function setCountry(string $country): self
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
     * @param integer $distance
     *
     * @return Application
     */
    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @param integer $minPrice
     *
     * @return Application
     */
    public function setMinPrice(int $minPrice): self
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinPrice(): int
    {
        return $this->minPrice;
    }

    /**
     * @param integer $maxPrice
     *
     * @return Application
     */
    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxPrice(): int
    {
        return $this->maxPrice;
    }

    /**
     * @param \PropertyBundle\Entity\SubType $subType
     *
     * @return Application
     */
    public function setSubType(SubType $subType = null): self
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * @return \PropertyBundle\Entity\SubType
     */
    public function getSubType(): SubType
    {
        return $this->subType;
    }

    /**
     * @param integer $rooms
     *
     * @return Application
     */
    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * @return int
     */
    public function getRooms(): int
    {
        return $this->rooms;
    }

    /**
     * @param \PropertyBundle\Entity\Terms $terms
     *
     * @return Application
     */
    public function setTerms(Terms $terms = null): self
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * @return \PropertyBundle\Entity\Terms
     */
    public function getTerms(): Terms
    {
        return $this->terms;
    }

    /**
     * @param boolean $active
     *
     * @return Application
     */
    public function setActive(bool $active): Application
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
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
