<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blacklist
 * @ORM\Table(name="blacklist")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\BlacklistRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Blacklist
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
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    protected $agent;

    /**
     * @var string
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var int
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount = 1;

    /**
     * @var \DateTime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime $updated
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

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
     * @return Blacklist
     */
    public function setUser(User $user = null): Blacklist
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return Blacklist
     */
    public function setAgent(Agent $agent = null): Blacklist
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\Agent
     */
    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    /**
     * @param string $ip
     *
     * @return Blacklist
     */
    public function setIp($ip): Blacklist
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param integer $amount
     *
     * @return Blacklist
     */
    public function setAmount(int $amount): Blacklist
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Blacklist
     */
    public function setCreated(?\DateTime $created): Blacklist
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
     * @param \DateTime|null $updated
     *
     * @return Blacklist
     */
    public function setUpdated(?\DateTime $updated): Blacklist
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}
