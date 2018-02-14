<?php
declare(strict_types = 1);

namespace Test\AlertBundle\Entity;

use AlertBundle\Entity\Alert;
use AlertBundle\Entity\Applicant;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Alert Test
 */
class AlertTest extends TestCase
{
    /**
     * @var Alert
     */
    private $alert;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->alert = new Alert();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->alert->getId());

        $applicant = new Applicant();

        $this->alert->setApplicant($applicant);
        $this->assertEquals($applicant, $this->alert->getApplicant());

        $property = new Property();

        $this->alert->setProperty($property);
        $this->assertEquals($property, $this->alert->getProperty());

        $this->alert->setRead(false);
        $this->assertFalse($this->alert->getRead());
    }
}
