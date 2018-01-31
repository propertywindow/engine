<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\OfferRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Offer
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
     * @var int
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

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
     * @return Offer
     */
    public function setBuyerId(int $buyerId): Offer
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
     * @return Offer
     */
    public function setPropertyId(int $propertyId): Offer
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
     * @param integer $amount
     *
     * @return Offer
     */
    public function setAmount(int $amount): Offer
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
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
