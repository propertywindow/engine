<?php declare(strict_types=1);

namespace AgentBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AgentBundle\Repository\ClientRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Client
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
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    private $agent;

    /**
     * @var bool
     * @ORM\Column(name="transparency", type="boolean")
     */
    private $transparency = false;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param \AuthenticationBundle\Entity\User $user
     *
     * @return Client
     */
    public function setUser(User $user): Client
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \AuthenticationBundle\Entity\User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param Agent $agent
     *
     * @return Client
     */
    public function setAgent(Agent $agent): Client
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
     * @param boolean $transparency
     *
     * @return Client
     */
    public function setTransparency(bool $transparency)
    {
        $this->transparency = $transparency;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTransparency(): bool
    {
        return $this->transparency;
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
