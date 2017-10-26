<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSettings
 *
 * @ORM\Table(name="user_settings")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\UserSettingsRepository")
 */
class UserSettings
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
     * @ORM\ManyToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=2)
     */
    private $language = 'en';

    /**
     * @var string
     *
     * @ORM\Column(name="email_name", type="string", length=255, nullable=true)
     */
    private $emailName;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=255, nullable=true)
     */
    private $emailAddress;

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
     * Set user
     *
     * @param User $user
     *
     * @return UserSettings
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return UserSettings
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
     * Set emailName
     *
     * @param string $emailName
     *
     * @return UserSettings
     */
    public function setEmailName($emailName)
    {
        $this->emailName = $emailName;

        return $this;
    }

    /**
     * Get emailName
     *
     * @return string
     */
    public function getEmailName()
    {
        return $this->emailName;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return UserSettings
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set IMAPAddress
     *
     * @param string $IMAPAddress
     *
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
     * @return UserSettings
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
