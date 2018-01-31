<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="interest")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\InterestRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Interest
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="buyer_id", type="integer")
     */
    private $buyerId;

    /**
     * @var int
     * @ORM\Column(name="property_id", type="integer")
     */
    private $propertyId;

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
     * @param integer $buyerId
     *
     * @return Interest
     */
    public function setBuyerId(int $buyerId): Interest
    {
        $this->buyerId = $buyerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getBuyerId(): int
    {
        return $this->buyerId;
    }

    /**
     * @param integer $propertyId
     *
     * @return Interest
     */
    public function setPropertyId(int $propertyId): Interest
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyId(): int
    {
        return $this->propertyId;
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
