<?php declare(strict_types = 1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="property_terms")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\TermsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Terms
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var bool
     * @ORM\Column(name="show_price", type="boolean", options={"default": false})
     */
    private $showPrice = false;

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
     * @param string $en
     *
     * @return Terms
     */
    public function setEn(string $en): Terms
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
     * @return Terms
     */
    public function setNl(string $nl): Terms
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
     * @param boolean $showPrice
     *
     * @return Terms
     */
    public function setShowPrice(bool $showPrice): Terms
    {
        $this->showPrice = $showPrice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowPrice(): bool
    {
        return $this->showPrice;
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
