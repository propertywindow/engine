<?php
declare(strict_types = 1);

namespace Tests\AlertBundle\Entity;

use AlertBundle\Entity\Application;
use AlertBundle\Entity\ApplicationMapping;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  ApplicationMapping Test
 */
class ApplicationMappingTest extends TestCase
{
    /**
     * @var ApplicationMapping
     */
    private $applicationMapping;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->applicationMapping = new ApplicationMapping();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->applicationMapping->getId());

        $application = new Application();

        $this->applicationMapping->setApplication($application);
        $this->assertEquals($application, $this->applicationMapping->getApplication());

        $property = new Property();

        $this->applicationMapping->setProperty($property);
        $this->assertEquals($property, $this->applicationMapping->getProperty());

        $this->applicationMapping->setDistance(1.5);
        $this->assertEquals(1.5, $this->applicationMapping->getDistance());
    }
}
