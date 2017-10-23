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
     * @ORM\Column(name="IMAP_server", type="string", length=255, nullable=true)
     */
    private $IMAPServer;

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
     * Set IMAPServer
     *
     * @param string $IMAPServer
     *
     * @return UserSettings
     */
    public function setIMAPServer($IMAPServer)
    {
        $this->IMAPServer = $IMAPServer;

        return $this;
    }

    /**
     * Get IMAPServer
     *
     * @return string
     */
    public function getIMAPServer()
    {
        return $this->IMAPServer;
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
}
