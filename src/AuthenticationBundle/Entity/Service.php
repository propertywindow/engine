<?php declare(strict_types=1);

namespace AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AuthenticationBundle\Repository\ServiceRepository")
 */
class Service
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
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer")
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="en", type="string", length=255)
     */
    private $en;

    /**
     * @var string
     *
     * @ORM\Column(name="nl", type="string", length=255)
     */
    private $nl;


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
     * Set groupId
     *
     * @param integer $groupId
     *
     * @return Service
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set en
     *
     * @param string $en
     *
     * @return Service
     */
    public function setEn($en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set nl
     *
     * @param string $nl
     *
     * @return Service
     */
    public function setNl($nl)
    {
        $this->nl = $nl;

        return $this;
    }

    /**
     * Get nl
     *
     * @return string
     */
    public function getNl()
    {
        return $this->nl;
    }
}