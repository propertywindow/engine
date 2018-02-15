<?php declare(strict_types = 1);

namespace AuthenticationBundle\Entity;

use AgentBundle\Entity\Agent;
use AppBundle\Entity\ContactAddress;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("email")
 */
class User
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ContactAddress")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="UserType")
     * @ORM\JoinColumn(name="user_type_id", referencedColumnName="id")
     */
    private $userType;

    /**
     * @var string
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var \datetime
     * @ORM\Column(name="last_login", type="datetime", length=255, nullable=true)
     */
    private $lastLogin;

    /**
     * @var \datetime
     * @ORM\Column(name="last_online", type="datetime", length=255, nullable=true)
     */
    private $lastOnline;

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean", options={"default": false})
     */
    private $active = false;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="ConversationBundle\Entity\Notification", mappedBy="users")
     */
    private $notifications;

    /**
     * @ORM\OneToOne(targetEntity="UserSettings", mappedBy="user")
     */
    protected $settings;

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
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param \AppBundle\Entity\ContactAddress $address
     *
     * @return User
     */
    public function setAddress(ContactAddress $address = null): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\ContactAddress|null
     */
    public function getAddress(): ?ContactAddress
    {
        return $this->address;
    }

    /**
     * @param string|null $phone
     *
     * @return User
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return User
     */
    public function setAgent(Agent $agent)
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
     * @param UserType $userType
     *
     * @return User
     */
    public function setUserType(UserType $userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * @return UserType
     */
    public function getUserType(): UserType
    {
        return $this->userType;
    }

    /**
     * @param string|null $avatar
     *
     * @return User
     */
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param \DateTime|null $lastLogin
     *
     * @return User
     */
    public function setLastLogin(?\DateTime $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime|null $lastOnline
     *
     * @return User
     */
    public function setLastOnline(?\DateTime $lastOnline): self
    {
        $this->lastOnline = $lastOnline;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastOnline(): ?\DateTime
    {
        return $this->lastOnline;
    }

    /**
     * @param bool $active
     *
     * @return User
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @return \ConversationBundle\Entity\Notification[]
     */
    public function getNotifications(): array
    {
        return $this->notifications->getValues();
    }

    /**
     * @return UserSettings
     */
    public function getSettings(): UserSettings
    {
        return $this->settings;
    }

    /**
     * @param \DateTime|null $created
     *
     * @return User
     */
    public function setCreated(?\DateTime $created): self
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
     * @return User
     */
    public function setUpdated(?\DateTime $updated): self
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
