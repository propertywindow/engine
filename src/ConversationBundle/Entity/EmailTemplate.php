<?php declare(strict_types=1);

namespace ConversationBundle\Entity;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;

/**
 * EmailTemplate
 *
 * @ORM\Table(name="email_template")
 * @ORM\Entity(repositoryClass="ConversationBundle\Repository\EmailTemplateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class EmailTemplate
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
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message_html", type="blob")
     */
    private $messageHTML;

    /**
     * @var string
     *
     * @ORM\Column(name="message_txt", type="blob")
     */
    private $messageTXT;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

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
     * Set agent
     *
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return EmailTemplate
     */
    public function setAgent(Agent $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \AgentBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set category
     *
     * @param EmailTemplateCategory $category
     *
     * @return EmailTemplate
     */
    public function setCategory(EmailTemplateCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EmailTemplate
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return EmailTemplate
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set messageHTML
     *
     * @param string $messageHTML
     *
     * @return EmailTemplate
     */
    public function setMessageHTML($messageHTML)
    {
        $this->messageHTML = $messageHTML;

        return $this;
    }

    /**
     * Get messageHTML
     *
     * @return string
     */
    public function getMessageHTML()
    {
        return $this->messageHTML;
    }

    /**
     * Set messageTXT
     *
     * @param string $messageTXT
     *
     * @return EmailTemplate
     */
    public function setMessageTXT($messageTXT)
    {
        $this->messageTXT = $messageTXT;

        return $this;
    }

    /**
     * Get messageTXT
     *
     * @return string
     */
    public function getMessageTXT()
    {
        return $this->messageTXT;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return EmailTemplate
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
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
