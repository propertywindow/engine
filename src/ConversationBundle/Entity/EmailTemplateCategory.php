<?php
declare(strict_types = 1);

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="email_template_category")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\EmailTemplateCategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class EmailTemplateCategory
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
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = false;

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
     * @return EmailTemplateCategory
     */
    public function setEn(string $en): EmailTemplateCategory
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
     * @return EmailTemplateCategory
     */
    public function setNl(string $nl): EmailTemplateCategory
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
     * @param boolean $active
     *
     * @return EmailTemplateCategory
     */
    public function setActive(bool $active): EmailTemplateCategory
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
     * @param \DateTime|null $created
     *
     * @return EmailTemplateCategory
     */
    public function setCreated(?\DateTime $created): EmailTemplateCategory
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
     * @return EmailTemplateCategory
     */
    public function setUpdated(?\DateTime $updated): EmailTemplateCategory
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
