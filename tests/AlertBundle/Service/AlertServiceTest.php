<?php
declare(strict_types=1);

namespace Tests\AlertBundle\Service;

use AlertBundle\Entity\Alert;
use AlertBundle\Entity\Applicant;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Alert Service Test
 */
class AlertServiceTest extends TestCase
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

    public function testCreateAlert()
    {
        $applicant = new Applicant();
        $property  = new Property();

        $this->alert->setApplicant($applicant);
        $this->alert->setProperty($property);
        $this->alert->setRead(false);


        $this->assertEquals($applicant, $this->alert->getApplicant());
        $this->assertEquals($property, $this->alert->getProperty());
        $this->assertInternalType('bool', $this->alert->getRead());
        $this->assertEquals(false, $this->alert->getRead());
    }
}
