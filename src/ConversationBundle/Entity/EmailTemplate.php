<?php declare(strict_types=1);

namespace ConversationBundle\Entity;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;

/**
 * EmailTemplate
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
    private $active;

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
    public function getId()
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
     * @return Category
     */
    public function getCategory(): Category
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
    public function setBodyHTML($bodyHTML): EmailTemplate
    {
        $this->bodyHTML = $bodyHTML;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyHTML()
    {
        return $this->bodyHTML;
    }

    /**
     * @param string $bodyTXT
     *
     * @return EmailTemplate
     */
    public function setBodyTXT($bodyTXT): EmailTemplate
    {
        $this->bodyTXT = $bodyTXT;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyTXT()
    {
        return $this->bodyTXT;
    }

    /**
     * @param boolean $active
     *
     * @return EmailTemplate
     */
    public function setActive($active): EmailTemplate
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
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
