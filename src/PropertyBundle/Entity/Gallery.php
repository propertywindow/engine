<?php declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 * @ORM\Table(name="property_gallery")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\GalleryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Gallery
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Property", inversedBy="images")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    private $property;

    /**
     * @var string
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     * @ORM\Column(name="overlay", type="string", length=255, nullable=true)
     */
    private $overlay;

    /**
     * @var bool
     * @ORM\Column(name="main", type="boolean", options={"default": false})
     */
    private $main = false;

    /**
     * @var int
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort = 0;

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
     * @param Property $property
     *
     * @return Gallery
     */
    public function setProperty(Property $property): Gallery
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }

    /**
     * @param string $path
     *
     * @return Gallery
     */
    public function setPath(string $path): Gallery
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string|null $overlay
     *
     * @return Gallery
     */
    public function setOverlay(?string $overlay): Gallery
    {
        $this->overlay = $overlay;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOverlay(): ?string
    {
        return $this->overlay;
    }

    /**
     * @param boolean $main
     *
     * @return Gallery
     */
    public function setMain(bool $main): Gallery
    {
        $this->main = $main;

        return $this;
    }

    /**
     * @return bool
     */
    public function getMain(): bool
    {
        return $this->main;
    }

    /**
     * @param integer $sort
     *
     * @return Gallery
     */
    public function setSort(int $sort): Gallery
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Gallery
     */
    public function setCreated(?\DateTime $created): Gallery
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime|null $updated
     *
     * @return Gallery
     */
    public function setUpdated(?\DateTime $updated): Gallery
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
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
