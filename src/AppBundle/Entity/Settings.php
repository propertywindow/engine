<?php declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingsRepository")
 */
class Settings
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
     * @var string
     *
     * @ORM\Column(name="application_name", type="string", length=255)
     */
    private $applicationName;

    /**
     * @var string
     *
     * @ORM\Column(name="application_URL", type="string", length=255)
     */
    private $applicationURL;

    /**
     * @var int
     *
     * @ORM\Column(name="max_failed_login", type="integer")
     */
    private $maxFailedLogin;


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
     * Set applicationName
     *
     * @param string $applicationName
     *
     * @return Settings
     */
    public function setApplicationName($applicationName)
    {
        $this->applicationName = $applicationName;

        return $this;
    }

    /**
     * Get applicationName
     *
     * @return string
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * Set applicationURL
     *
     * @param string $applicationURL
     *
     * @return Settings
     */
    public function setApplicationURL($applicationURL)
    {
        $this->applicationURL = $applicationURL;

        return $this;
    }

    /**
     * Get applicationURL
     *
     * @return string
     */
    public function getApplicationURL()
    {
        return $this->applicationURL;
    }

    /**
     * Set maxFailedLogin
     *
     * @param integer $maxFailedLogin
     *
     * @return Settings
     */
    public function setMaxFailedLogin($maxFailedLogin)
    {
        $this->maxFailedLogin = $maxFailedLogin;

        return $this;
    }

    /**
     * Get maxFailedLogin
     *
     * @return int
     */
    public function getMaxFailedLogin()
    {
        return $this->maxFailedLogin;
    }
}
