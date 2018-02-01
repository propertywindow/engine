<?php
declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="property_type")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\TypeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Type
{
    /**
     * @var int
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
     * @ORM\Column(name="en", type="string", length=255)
     */
    private $en;

    /**
     * @var string
     * @ORM\Column(name="nl", type="string", length=255)
     */
    private $nl;

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
        $this->subTypes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param SubType $subTypes
     *
     * @return Type
     */
    public function addSubType(SubType $subTypes): Type
    {
        $this->subTypes[] = $subTypes;

        return $this;
    }

    /**
     * @param SubType $subType
     */
    public function removeSubType(SubType $subType)
    {
        $this->subTypes->removeElement($subType);
    }

    /**
     * @return Collection
     */
    public function getSubTypes()
    {
        return $this->subTypes;
    }

    /**
     * @param string $en
     *
     * @return Type
     */
    public function setEn(string $en): Type
    {
        $this->en = $en;

        return $this;
    }

    /**
     * @return string
     */
    public function getEn(): string
    {
        return $this->en;
    }

    /**
     * @param string $nl
     *
     * @return Type
     */
    public function setNl(string $nl): Type
    {
        $this->nl = $nl;

        return $this;
    }

    /**
     * @return string
     */
    public function getNl(): string
    {
        return $this->nl;
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
