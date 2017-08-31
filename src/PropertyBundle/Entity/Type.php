<?php declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="property_type")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\TypeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Type
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
     * @ORM\OneToMany(targetEntity="SubType", mappedBy="type")
     */
    private $subTypes;

    /**
     * @var string
     *
     * @ORM\Column(name="en", type="string", length=255)
     */
    private $en;

    /**
     * @var string
     *
     * @ORM\Column(name="nl", type="string", length=255)
     */
    private $nl;

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
     * Constructor
     */
    public function __construct()
    {
        $this->subTypes = new ArrayCollection();
    }

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
     * Add subType
     *
     * @param SubType $subTypes
     *
     * @return Type
     */
    public function addSubType(SubType $subTypes)
    {
        $this->subTypes[] = $subTypes;

        return $this;
    }

    /**
     * Remove subType
     *
     * @param SubType $subType
     */
    public function removeSubType(SubType $subType)
    {
        $this->subTypes->removeElement($subType);
    }

    /**
     * Get subTypes
     *
     * @return Collection
     */
    public function getSubTypes()
    {
        return $this->subTypes;
    }

    /**
     * Set en
     *
     * @param string $en
     *
     * @return Type
     */
    public function setEn($en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set nl
     *
     * @param string $nl
     *
     * @return Type
     */
    public function setNl($nl)
    {
        $this->nl = $nl;

        return $this;
    }

    /**
     * Get nl
     *
     * @return string
     */
    public function getNl()
    {
        return $this->nl;
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
