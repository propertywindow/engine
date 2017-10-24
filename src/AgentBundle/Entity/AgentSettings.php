<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgentSettings
 *
 * @ORM\Table(name="agent_settings")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\AgentSettingsRepository")
 */
class AgentSettings
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
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    protected $agent;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=2)
     */
    private $language = 'en';

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3)
     */
    private $currency = 'EUR';

    /**
     * @var string
     *
     * @ORM\Column(name="IMAP_address", type="string", length=255, nullable=true)
     */
    private $IMAPAddress;

    /**
     * @var int
     *
     * @ORM\Column(name="IMAP_port", type="integer", nullable=true)
     */
    private $IMAPPort;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAP_secure", type="string", length=3, nullable=true)
     */
    private $IMAPSecure;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAP_username", type="string", length=255, nullable=true)
     */
    private $IMAPUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAP_password", type="string", length=255, nullable=true)
     */
    private $IMAPPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="SMTP_address", type="string", length=255, nullable=true)
     */
    private $SMTPAddress;

    /**
     * @var int
     *
     * @ORM\Column(name="SMTP_port", type="integer", nullable=true)
     */
    private $SMTPPort;

    /**
     * @var string
     *
     * @ORM\Column(name="SMTP_secure", type="string", length=3, nullable=true)
     */
    private $SMTPSecure;

    /**
     * @var string
     *
     * @ORM\Column(name="SMTP_username", type="string", length=255, nullable=true)
     */
    private $SMTPUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="SMTP_password", type="string", length=255, nullable=true)
     */
    private $SMTPPassword;


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
     * @param Agent $agent
     *
     * @return AgentSettings
     */
    public function setAgent(Agent $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return AgentSettings
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return AgentSettings
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set IMAPAddress
     *
     * @param string $IMAPAddress
     *
     * @return AgentSettings
     */
    public function setIMAPAddress($IMAPAddress)
    {
        $this->IMAPAddress = $IMAPAddress;

        return $this;
    }

    /**
     * Get IMAPAddress
     *
     * @return string
     */
    public function getIMAPAddress()
    {
        return $this->IMAPAddress;
    }

    /**
     * Set IMAPPort
     *
     * @param int $IMAPPort
     *
     * @return AgentSettings
     */
    public function setIMAPPort($IMAPPort)
    {
        $this->IMAPPort = $IMAPPort;

        return $this;
    }

    /**
     * Get IMAPPort
     *
     * @return integer
     */
    public function getIMAPPort()
    {
        return $this->IMAPPort;
    }

    /**
     * Set IMAPSecure
     *
     * @param string $IMAPSecure
     *
     * @return AgentSettings
     */
    public function setIMAPSecure($IMAPSecure)
    {
        $this->IMAPSecure = $IMAPSecure;

        return $this;
    }

    /**
     * Get IMAPSecure
     *
     * @return string
     */
    public function getIMAPSecure()
    {
        return $this->IMAPSecure;
    }

    /**
     * Set IMAPUsername
     *
     * @param string $IMAPUsername
     *
     * @return AgentSettings
     */
    public function setIMAPUsername($IMAPUsername)
    {
        $this->IMAPUsername = $IMAPUsername;

        return $this;
    }

    /**
     * Get IMAPUsername
     *
     * @return string
     */
    public function getIMAPUsername()
    {
        return $this->IMAPUsername;
    }

    /**
     * Set IMAPPassword
     *
     * @param string $IMAPPassword
     *
     * @return AgentSettings
     */
    public function setIMAPPassword($IMAPPassword)
    {
        $this->IMAPPassword = $IMAPPassword;

        return $this;
    }

    /**
     * Get IMAPPassword
     *
     * @return string
     */
    public function getIMAPPassword()
    {
        return $this->IMAPPassword;
    }

    /**
     * Set SMTPAddress
     *
     * @param string $SMTPAddress
     *
     * @return AgentSettings
     */
    public function setSMTPAddress($SMTPAddress)
    {
        $this->SMTPAddress = $SMTPAddress;

        return $this;
    }

    /**
     * Get SMTPAddress
     *
     * @return string
     */
    public function getSMTPAddress()
    {
        return $this->SMTPAddress;
    }

    /**
     * Set SMTPPort
     *
     * @param int $SMTPPort
     *
     * @return AgentSettings
     */
    public function setSMTPPort($SMTPPort)
    {
        $this->SMTPPort = $SMTPPort;

        return $this;
    }

    /**
     * Get SMTPPort
     *
     * @return integer
     */
    public function getSMTPPort()
    {
        return $this->SMTPPort;
    }

    /**
     * Set SMTPSecure
     *
     * @param string $SMTPSecure
     *
     * @return AgentSettings
     */
    public function setSMTPSecure($SMTPSecure)
    {
        $this->SMTPSecure = $SMTPSecure;

        return $this;
    }

    /**
     * Get SMTPSecure
     *
     * @return string
     */
    public function getSMTPSecure()
    {
        return $this->SMTPSecure;
    }

    /**
     * Set SMTPUsername
     *
     * @param string $SMTPUsername
     *
     * @return AgentSettings
     */
    public function setSMTPUsername($SMTPUsername)
    {
        $this->SMTPUsername = $SMTPUsername;

        return $this;
    }

    /**
     * Get SMTPUsername
     *
     * @return string
     */
    public function getSMTPUsername()
    {
        return $this->SMTPUsername;
    }

    /**
     * Set SMTPPassword
     *
     * @param string $SMTPPassword
     *
     * @return AgentSettings
     */
    public function setSMTPPassword($SMTPPassword)
    {
        $this->SMTPPassword = $SMTPPassword;

        return $this;
    }

    /**
     * Get SMTPPassword
     *
     * @return string
     */
    public function getSMTPPassword()
    {
        return $this->SMTPPassword;
    }
}
