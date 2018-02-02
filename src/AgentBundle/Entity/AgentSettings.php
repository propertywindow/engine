<?php
declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agent_settings")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\AgentSettingsRepository")
 */
class AgentSettings
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    protected $agent;

    /**
     * @var string
     * @ORM\Column(name="language", type="string", length=2)
     */
    private $language = 'en';

    /**
     * @var string
     * @ORM\Column(name="currency", type="string", length=3)
     */
    private $currency = 'EUR';

    /**
     * @var string
     * @ORM\Column(name="email_name", type="string", length=255, nullable=true)
     */
    private $emailName;

    /**
     * @var string
     * @ORM\Column(name="email_address", type="string", length=255, nullable=true)
     */
    private $emailAddress;

    /**
     * @var string
     * @ORM\Column(name="IMAP_address", type="string", length=255, nullable=true)
     */
    private $IMAPAddress;

    /**
     * @var int
     * @ORM\Column(name="IMAP_port", type="integer", nullable=true)
     */
    private $IMAPPort;

    /**
     * @var string
     * @ORM\Column(name="IMAP_secure", type="string", length=3, nullable=true)
     */
    private $IMAPSecure;

    /**
     * @var string
     * @ORM\Column(name="IMAP_username", type="string", length=255, nullable=true)
     */
    private $IMAPUsername;

    /**
     * @var string
     * @ORM\Column(name="IMAP_password", type="string", length=255, nullable=true)
     */
    private $IMAPPassword;

    /**
     * @var string
     * @ORM\Column(name="SMTP_address", type="string", length=255, nullable=true)
     */
    private $SMTPAddress;

    /**
     * @var int
     * @ORM\Column(name="SMTP_port", type="integer", nullable=true)
     */
    private $SMTPPort;

    /**
     * @var string
     * @ORM\Column(name="SMTP_secure", type="string", length=3, nullable=true)
     */
    private $SMTPSecure;

    /**
     * @var string
     * @ORM\Column(name="SMTP_username", type="string", length=255, nullable=true)
     */
    private $SMTPUsername;

    /**
     * @var string
     * @ORM\Column(name="SMTP_password", type="string", length=255, nullable=true)
     */
    private $SMTPPassword;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Agent $agent
     *
     * @return AgentSettings
     */
    public function setAgent(Agent $agent): AgentSettings
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @param string $language
     *
     * @return AgentSettings
     */
    public function setLanguage(string $language): AgentSettings
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $currency
     *
     * @return AgentSettings
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string|null $emailName
     *
     * @return AgentSettings
     */
    public function setEmailName(?string $emailName): AgentSettings
    {
        $this->emailName = $emailName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailName(): ?string
    {
        return $this->emailName;
    }

    /**
     * @param string|null $emailAddress
     *
     * @return AgentSettings
     */
    public function setEmailAddress(?string $emailAddress): AgentSettings
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * @param string|null $IMAPAddress
     *
     * @return AgentSettings
     */
    public function setIMAPAddress(?string $IMAPAddress): AgentSettings
    {
        $this->IMAPAddress = $IMAPAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIMAPAddress(): ?string
    {
        return $this->IMAPAddress;
    }

    /**
     * @param int|null $IMAPPort
     *
     * @return AgentSettings
     */
    public function setIMAPPort(?int $IMAPPort): AgentSettings
    {
        $this->IMAPPort = $IMAPPort;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getIMAPPort(): ?int
    {
        return $this->IMAPPort;
    }

    /**
     * @param string|null $IMAPSecure
     *
     * @return AgentSettings
     */
    public function setIMAPSecure(?string $IMAPSecure): AgentSettings
    {
        $this->IMAPSecure = $IMAPSecure;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIMAPSecure(): ?string
    {
        return $this->IMAPSecure;
    }

    /**
     * @param string|null $IMAPUsername
     *
     * @return AgentSettings
     */
    public function setIMAPUsername(?string $IMAPUsername): AgentSettings
    {
        $this->IMAPUsername = $IMAPUsername;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIMAPUsername(): ?string
    {
        return $this->IMAPUsername;
    }

    /**
     * @param string|null $IMAPPassword
     *
     * @return AgentSettings
     */
    public function setIMAPPassword(?string $IMAPPassword): AgentSettings
    {
        $this->IMAPPassword = $IMAPPassword;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIMAPPassword(): ?string
    {
        return $this->IMAPPassword;
    }

    /**
     * @param string|null $SMTPAddress
     *
     * @return AgentSettings
     */
    public function setSMTPAddress(?string $SMTPAddress): AgentSettings
    {
        $this->SMTPAddress = $SMTPAddress;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSMTPAddress(): ?string
    {
        return $this->SMTPAddress;
    }

    /**
     * @param int|null $SMTPPort
     *
     * @return AgentSettings
     */
    public function setSMTPPort(?int $SMTPPort): AgentSettings
    {
        $this->SMTPPort = $SMTPPort;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getSMTPPort(): ?int
    {
        return $this->SMTPPort;
    }

    /**
     * @param string|null $SMTPSecure
     *
     * @return AgentSettings
     */
    public function setSMTPSecure(?string $SMTPSecure): AgentSettings
    {
        $this->SMTPSecure = $SMTPSecure;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSMTPSecure(): ?string
    {
        return $this->SMTPSecure;
    }

    /**
     * @param string|null $SMTPUsername
     *
     * @return AgentSettings
     */
    public function setSMTPUsername(?string $SMTPUsername): AgentSettings
    {
        $this->SMTPUsername = $SMTPUsername;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSMTPUsername(): ?string
    {
        return $this->SMTPUsername;
    }

    /**
     * @param string|null $SMTPPassword
     *
     * @return AgentSettings
     */
    public function setSMTPPassword(?string $SMTPPassword): AgentSettings
    {
        $this->SMTPPassword = $SMTPPassword;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSMTPPassword(): ?string
    {
        return $this->SMTPPassword;
    }
}
