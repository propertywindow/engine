<?php
declare(strict_types=1);

namespace Tests\AlertBundle\Service;

use AlertBundle\Entity\Applicant;
use AlertBundle\Entity\Application;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;

/**
 *  Application Service Test
 */
class ApplicationServiceTest extends TestCase
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->application = new Application();
    }

    public function testCreateApplication()
    {
        $applicant = new Applicant();
        $kind      = new Kind();
        $subType   = new SubType();
        $terms     = new Terms();

        $this->application->setApplicant($applicant);
        $this->application->setKind($kind);
        $this->application->setSubType($subType);
        $this->application->setTerms($terms);
        $this->application->setPostcode('5754DW');
        $this->application->setCountry('NL');
        $this->application->setDistance(15);
        $this->application->setMinPrice(150000);
        $this->application->setMaxPrice(450000);
        $this->application->setRooms(3);
        $this->application->setActive(true);

        $this->assertEquals($applicant, $this->application->getApplicant());
        $this->assertEquals($kind, $this->application->getKind());
        $this->assertEquals($subType, $this->application->getSubType());
        $this->assertEquals($terms, $this->application->getTerms());
        $this->assertEquals('5754DW', $this->application->getPostcode());
        $this->assertEquals('NL', $this->application->getCountry());
        $this->assertInternalType('int', $this->application->getDistance());
        $this->assertEquals(15, $this->application->getDistance());
        $this->assertInternalType('int', $this->application->getMinPrice());
        $this->assertEquals(150000, $this->application->getMinPrice());
        $this->assertInternalType('int', $this->application->getMaxPrice());
        $this->assertEquals(450000, $this->application->getMaxPrice());
        $this->assertInternalType('int', $this->application->getRooms());
        $this->assertEquals(3, $this->application->getRooms());
        $this->assertInternalType('bool', $this->application->getActive());
        $this->assertEquals(true, $this->application->getActive());
    }
}
