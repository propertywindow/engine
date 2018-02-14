<?php
declare(strict_types = 1);

namespace LogBundle\Entity;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="log_activity")
 * @ORM\Entity(repositoryClass="LogBundle\Repository\ActivityRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Activity
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
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    protected $agent;

    /**
     * @var int
     * @ORM\Column(name="action_id", type="integer", nullable=true)
     */
    private $actionId;

    /**
     * @var string
     * @ORM\Column(name="action_category", type="string", length=255, nullable=true)
     */
    private $actionCategory;

    /**
     * @var string
     * @ORM\Column(name="action_name", type="string", length=255, nullable=true)
     */
    private $actionName;

    /**
     * @var string
     * @ORM\Column(name="old_value", type="json_array", nullable=true)
     */
    private $oldValue;

    /**
     * @var string
     * @ORM\Column(name="new_value", type="json_array")
     */
    private $newValue;

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
     * @return Activity
     */
    public function setUser(User $user): Activity
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
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return Activity
     */
    public function setAgent(Agent $agent): Activity
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @param integer $actionId
     *
     * @return Activity
     */
    public function setActionId(int $actionId): Activity
    {
        $this->actionId = $actionId;

        return $this;
    }

    /**
     * @return int
     */
    public function getActionId(): int
    {
        return $this->actionId;
    }

    /**
     * @param string|null $actionCategory
     *
     * @return Activity
     */
    public function setActionCategory(?string $actionCategory): Activity
    {
        $this->actionCategory = $actionCategory;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActionCategory(): ?string
    {
        return $this->actionCategory;
    }

    /**
     * @param string|null $actionName
     *
     * @return Activity
     */
    public function setActionName(?string $actionName): Activity
    {
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * @return string
     */
    public function getActionName(): ?string
    {
        return $this->actionName;
    }

    /**
     * @param string|null $oldValue
     *
     * @return Activity
     */
    public function setOldValue(?string $oldValue): Activity
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOldValue(): ?string
    {
        return $this->oldValue;
    }

    /**
     * @param string|null $newValue
     *
     * @return Activity
     */
    public function setNewValue(?string $newValue): Activity
    {
        $this->newValue = $newValue;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewValue(): ?string
    {
        return $this->newValue;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return Activity
     */
    public function setCreated(?\DateTime $created): Activity
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
