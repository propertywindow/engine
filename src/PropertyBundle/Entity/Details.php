<?php  declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Details
 *
 * @ORM\Table(name="property_details")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\DetailsRepository")
 */
class Details
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
     * @ORM\Column(name="rooms", type="integer")
     */
    private $rooms;


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
     * @return Details
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
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return Details
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return int
     */
    public function getRooms()
    {
        return $this->rooms;
    }
}
