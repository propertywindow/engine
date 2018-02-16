<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingsRepository")
 */
class Settings
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="application_name", type="string", length=255)
     */
    private $applicationName;

    /**
     * @var string
     * @ORM\Column(name="application_URL", type="string", length=255)
     */
    private $applicationURL;

    /**
     * @var int
     * @ORM\Column(name="max_failed_login", type="integer")
     */
    private $maxFailedLogin;

    /**
     * @var bool
     * @ORM\Column(name="slack_enabled", type="boolean", options={"default": true})
     */
    private $slackEnabled = true;

    /**
     * @var string
     * @ORM\Column(name="slack_url", type="string", length=255)
     */
    private $slackURL;

    /**
     * @var string
     * @ORM\Column(name="slack_username", type="string", length=255)
     */
    private $slackUsername;

    /**
     * @var string
     * @ORM\Column(name="google_key", type="string", length=255)
     */
    private $googleKey;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $applicationName
     *
     * @return Settings
     */
    public function setApplicationName(string $applicationName): self
    {
        $this->applicationName = $applicationName;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationName(): string
    {
        return $this->applicationName;
    }

    /**
     * @param string $applicationURL
     *
     * @return Settings
     */
    public function setApplicationURL(string $applicationURL): self
    {
        $this->applicationURL = $applicationURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationURL(): string
    {
        return $this->applicationURL;
    }

    /**
     * @param integer $maxFailedLogin
     *
     * @return Settings
     */
    public function setMaxFailedLogin(int $maxFailedLogin): self
    {
        $this->maxFailedLogin = $maxFailedLogin;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxFailedLogin(): int
    {
        return $this->maxFailedLogin;
    }

    /**
     * @param boolean $slackEnabled
     *
     * @return Settings
     */
    public function setSlackEnabled(bool $slackEnabled): self
    {
        $this->slackEnabled = $slackEnabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSlackEnabled(): bool
    {
        return $this->slackEnabled;
    }

    /**
     * @param string $slackURL
     *
     * @return Settings
     */
    public function setSlackURL(string $slackURL): self
    {
        $this->slackURL = $slackURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlackURL(): string
    {
        return $this->slackURL;
    }

    /**
     * @param string $slackUsername
     *
     * @return Settings
     */
    public function setSlackUsername(string $slackUsername): self
    {
        $this->slackUsername = $slackUsername;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlackUsername(): string
    {
        return $this->slackUsername;
    }

    /**
     * @param string $googleKey
     *
     * @return Settings
     */
    public function setGoogleKey(string $googleKey): self
    {
        $this->googleKey = $googleKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleKey(): string
    {
        return $this->googleKey;
    }
}
