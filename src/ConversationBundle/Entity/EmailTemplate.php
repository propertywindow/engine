<?php
declare(strict_types=1);

namespace ConversationBundle\Entity;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="email_template")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\EmailTemplateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class EmailTemplate
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="ConversationBundle\Entity\EmailTemplateCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="body_html", type="text")
     */
    private $bodyHTML;

    /**
     * @var string
     * @ORM\Column(name="body_txt", type="text")
     */
    private $bodyTXT;


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
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return EmailTemplate
     */
    public function setAgent(Agent $agent = null): EmailTemplate
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @param EmailTemplateCategory $category
     *
     * @return EmailTemplate
     */
    public function setCategory(EmailTemplateCategory $category = null): EmailTemplate
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return EmailTemplateCategory
     */
    public function getCategory(): EmailTemplateCategory
    {
        return $this->category;
    }

    /**
     * @param string $name
     *
     * @return EmailTemplate
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $subject
     *
     * @return EmailTemplate
     */
    public function setSubject(string $subject): EmailTemplate
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $bodyHTML
     *
     * @return EmailTemplate
     */
    public function setBodyHTML(string $bodyHTML): EmailTemplate
    {
        $this->bodyHTML = $bodyHTML;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyHTML(): string
    {
        return $this->bodyHTML;
    }

    /**
     * @param string $bodyTXT
     *
     * @return EmailTemplate
     */
    public function setBodyTXT(string $bodyTXT): EmailTemplate
    {
        $this->bodyTXT = $bodyTXT;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyTXT(): string
    {
        return $this->bodyTXT;
    }

    /**
     * @param boolean $active
     *
     * @return EmailTemplate
     */
    public function setActive(bool $active): EmailTemplate
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
     * @return EmailTemplate
     */
    public function setCreated(?\DateTime $created): EmailTemplate
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
     * @return EmailTemplate
     */
    public function setUpdated(?\DateTime $updated): EmailTemplate
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
