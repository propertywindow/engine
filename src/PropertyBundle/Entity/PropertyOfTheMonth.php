<?php declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyOfTheMonth
 *
 * @ORM\Table(name="property_of_the_month")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\PropertyOfTheMonthRepository")
 */
class PropertyOfTheMonth
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
     * @ORM\Column(name="property_id", type="integer")
     */
    private $propertyId;

    /**
     * @var int
     *
     * @ORM\Column(name="agent_id", type="integer")
     */
    private $agentId;


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
     * Set propertyId
     *
     * @param integer $propertyId
     *
     * @return PropertyOfTheMonth
     */
    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * Get propertyId
     *
     * @return int
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Set agentId
     *
     * @param integer $agentId
     *
     * @return PropertyOfTheMonth
     */
    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * Get agentId
     *
     * @return int
     */
    public function getAgentId()
    {
        return $this->agentId;
    }
}