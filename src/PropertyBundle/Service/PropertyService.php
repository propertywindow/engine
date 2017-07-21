<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManager;
use PropertyBundle\Entity\Property;

/**
 * @package PropertyBundle\Service
 */
class PropertyService
{
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * @return Property[] $properties
     */
    public function listAll()
    {
        $properties = $this->em->getRepository('PropertyBundle:Property')->findAll();

        return $properties;
    }

    /**
     * @param int $id
     *
     * @return object $property
     */
    public function viewProperty($id)
    {
        $property = $this->em->getRepository('PropertyBundle:PropertySale')->find($id);

        return $property;
    }

    /**
     * @return Property $property
     */
    public function createProperty()
    {
        $property = new Property();
        $property->setAddress('58 Parkside Street');
        $property->setPrice(250000);
        $property->setDescription('Some description goes here');

        $this->em->persist($property);

        $this->em->flush();

        return $property;
    }
}
