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
     * @var bool
     *
     * @ORM\Column(name="slack_enabled", type="boolean", options={"default": true})
     */
    private $slackEnabled = true;

    /**
     * @var string
     *
     * @ORM\Column(name="slack_url", type="string", length=255)
     */
    private $slackURL;

    /**
     * @var string
     *
     * @ORM\Column(name="slack_username", type="string", length=255)
     */
    private $slackUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="slack_channel", type="string", length=255)
     */
    private $slackChannel;

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

    /**
     * Set slackEnabled
     *
     * @param boolean $slackEnabled
     *
     * @return Settings
     */
    public function setSlackEnabled($slackEnabled)
    {
        $this->slackEnabled = $slackEnabled;

        return $this;
    }

    /**
     * Get slackEnabled
     *
     * @return bool
     */
    public function getSlackEnabled()
    {
        return $this->slackEnabled;
    }

    /**
     * Set slackURL
     *
     * @param string $slackURL
     *
     * @return Settings
     */
    public function setSlackURL($slackURL)
    {
        $this->slackURL = $slackURL;

        return $this;
    }

    /**
     * Get slackURL
     *
     * @return string
     */
    public function getSlackURL()
    {
        return $this->slackURL;
    }

    /**
     * Set slackUsername
     *
     * @param string $slackUsername
     *
     * @return Settings
     */
    public function setSlackUsername($slackUsername)
    {
        $this->slackUsername = $slackUsername;

        return $this;
    }

    /**
     * Get slackUsername
     *
     * @return string
     */
    public function getSlackUsername()
    {
        return $this->slackUsername;
    }

    /**
     * Set slackChannel
     *
     * @param string $slackChannel
     *
     * @return Settings
     */
    public function setSlackChannel($slackChannel)
    {
        $this->slackChannel = $slackChannel;

        return $this;
    }

    /**
     * Get slackChannel
     *
     * @return string
     */
    public function getSlackChannel()
    {
        return $this->slackChannel;
    }
}
