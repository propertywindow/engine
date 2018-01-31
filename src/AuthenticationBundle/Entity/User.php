<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use AgentBundle\Entity\Agent;
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
     * @var string
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     * @ORM\Column(name="house_number", type="string", length=10)
     */
    private $houseNumber;

    /**
     * @var string
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=2)
     */
    private $country;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
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
    public function setPassword($password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName(string $firstName): User
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
    public function setLastName(string $lastName): User
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
     * @param string $street
     *
     * @return User
     */
    public function setStreet(string $street): User
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $houseNumber
     *
     * @return User
     */
    public function setHouseNumber(string $houseNumber): User
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * @param string $postcode
     *
     * @return User
     */
    public function setPostcode(string $postcode): User
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * @param string $city
     *
     * @return User
     */
    public function setCity(string $city): User
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $country
     *
     * @return User
     */
    public function setCountry(string $country): User
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone): User
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
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
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar): User
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param \datetime $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin): User
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return \datetime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param \datetime $lastOnline
     *
     * @return User
     */
    public function setLastOnline($lastOnline): User
    {
        $this->lastOnline = $lastOnline;

        return $this;
    }

    /**
     * @return \datetime
     */
    public function getLastOnline()
    {
        return $this->lastOnline;
    }

    /**
     * @param bool $active
     *
     * @return User
     */
    public function setActive(bool $active): User
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
