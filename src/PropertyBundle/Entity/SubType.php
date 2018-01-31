<?php
declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="property_sub_type")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\SubTypeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SubType
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="subTypes")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Type $type
     *
     * @return SubType
     */
    public function setType(Type $type): SubType
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param string $en
     *
     * @return SubType
     */
    public function setEn(string $en): SubType
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
     * @return SubType
     */
    public function setNl(string $nl): SubType
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
