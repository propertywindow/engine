<?php declare(strict_types=1);

namespace LogBundle\Entity;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Activity
 *
 * @ORM\Table(name="log_activity")
 * @ORM\Entity(repositoryClass="LogBundle\Repository\ActivityRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Activity
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
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var int
     *
     * @ORM\Column(name="action_id", type="integer", nullable=true)
     */
    private $actionId;

    /**
     * @var string
     *
     * @ORM\Column(name="action_category", type="string", length=255, nullable=true)
     */
    private $actionCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="action_name", type="string", length=255, nullable=true)
     */
    private $actionName;

    /**
     * @var string
     *
     * @ORM\Column(name="old_value", type="json_array", nullable=true)
     */
    private $oldValue;

    /**
     * @var string
     *
     * @ORM\Column(name="new_value", type="json_array")
     */
    private $newValue;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;


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
     * @param \AuthenticationBundle\Entity\User $user
     *
     * @return Activity
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AuthenticationBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set actionId
     *
     * @param integer $actionId
     *
     * @return Activity
     */
    public function setActionId($actionId)
    {
        $this->actionId = $actionId;

        return $this;
    }

    /**
     * Get actionId
     *
     * @return int
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * Set actionCategory
     *
     * @param string $actionCategory
     *
     * @return Activity
     */
    public function setActionCategory($actionCategory)
    {
        $this->actionCategory = $actionCategory;

        return $this;
    }

    /**
     * Get actionCategory
     *
     * @return string
     */
    public function getActionCategory()
    {
        return $this->actionCategory;
    }

    /**
     * Set actionName
     *
     * @param string $actionName
     *
     * @return Activity
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * Get actionName
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Set oldValue
     *
     * @param array $oldValue
     *
     * @return Activity
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    /**
     * Get oldValue
     *
     * @return string
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * Set newValue
     *
     * @param array $newValue
     *
     * @return Activity
     */
    public function setNewValue($newValue)
    {
        $this->newValue = $newValue;

        return $this;
    }

    /**
     * Get newValue
     *
     * @return string
     */
    public function getNewValue()
    {
        return $this->newValue;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }
}
