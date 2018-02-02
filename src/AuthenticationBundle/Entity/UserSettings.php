<?php
declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_settings")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\UserSettingsRepository")
 */
class UserSettings
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(name="language", type="string", length=2)
     */
    private $language = 'en';

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
     * @param User $user
     *
     * @return UserSettings
     */
    public function setUser(User $user): UserSettings
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param string|null $language
     *
     * @return UserSettings
     */
    public function setLanguage(?string $language): UserSettings
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $emailName
     *
     * @return UserSettings
     */
    public function setEmailName(?string $emailName): UserSettings
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
     * @return UserSettings
     */
    public function setEmailAddress(?string $emailAddress): UserSettings
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
     * @return UserSettings
     */
    public function setIMAPAddress(?string $IMAPAddress): UserSettings
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
     * @return UserSettings
     */
    public function setIMAPPort(?int $IMAPPort): UserSettings
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
     * @return UserSettings
     */
    public function setIMAPSecure(?string $IMAPSecure): UserSettings
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
     * @return UserSettings
     */
    public function setIMAPUsername(?string $IMAPUsername): UserSettings
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
     * @return UserSettings
     */
    public function setIMAPPassword(?string $IMAPPassword): UserSettings
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
     * @return UserSettings
     */
    public function setSMTPAddress(?string $SMTPAddress): UserSettings
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
     * @return UserSettings
     */
    public function setSMTPPort(?int $SMTPPort): UserSettings
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
     * @return UserSettings
     */
    public function setSMTPSecure(?string $SMTPSecure): UserSettings
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
     * @return UserSettings
     */
    public function setSMTPUsername(?string $SMTPUsername): UserSettings
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
     * @return UserSettings
     */
    public function setSMTPPassword(?string $SMTPPassword): UserSettings
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
