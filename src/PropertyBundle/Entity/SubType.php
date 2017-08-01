<?php declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubType
 *
 * @ORM\Table(name="property_sub_type")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\SubTypeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SubType
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
     * @ORM\Column(name="type_id", type="integer")
     */
    private $typeId;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return SubType
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set en
     *
     * @param string $en
     *
     * @return SubType
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
     * @return SubType
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
