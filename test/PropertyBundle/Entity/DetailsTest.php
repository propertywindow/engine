<?php
declare(strict_types = 1);

namespace Tests\PropertyBundle\Entity;

use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Details;
use PropertyBundle\Entity\Property;

/**
 *  Details Test
 */
class DetailsTest extends TestCase
{
    /**
     * @var Details
     */
    private $details;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->details = new Details();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->details->getId());

        $property = new Property();

        $this->details->setProperty($property);
        $this->assertEquals($property, $this->details->getProperty());

        $this->details->setRooms(5);
        $this->assertEquals(5, $this->details->getRooms());
    }
}
