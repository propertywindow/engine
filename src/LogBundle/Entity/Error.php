<?php
declare(strict_types=1);

namespace LogBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="log_error")
 * @ORM\Entity(repositoryClass="LogBundle\Repository\ErrorRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Error
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AuthenticationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(name="method", type="string", length=255)
     */
    private $method;

    /**
     * @var string
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var array|null
     * @ORM\Column(name="parameters", type="array", nullable=true)
     */
    private $parameters = [];


    /**
     * @var \DateTime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param \AuthenticationBundle\Entity\User $user
     *
     * @return Error
     */
    public function setUser(User $user = null): Error
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \AuthenticationBundle\Entity\User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param string $method
     *
     * @return Error
     */
    public function setMethod(string $method): Error
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $message
     *
     * @return Error
     */
    public function setMessage(string $message): Error
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param array|null $parameters
     *
     * @return Error
     */
    public function setParameters(?array $parameters = null): Error
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Error
     */
    public function setCreated(?\DateTime $created): Error
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }
}
