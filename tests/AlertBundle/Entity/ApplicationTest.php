<?php
declare(strict_types=1);

namespace Tests\AlertBundle\Entity;

use AlertBundle\Entity\Applicant;
use AlertBundle\Entity\Application;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;

/**
 *  Applicant Test
 */
class ApplicationTest extends TestCase
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

    public function testGetterAndSetter()
    {
        $this->assertNull($this->application->getId());

        $applicant = new Applicant();

        $this->application->setApplicant($applicant);
        $this->assertEquals($applicant, $this->application->getApplicant());

        $kind = new Kind();

        $this->application->setKind($kind);
        $this->assertEquals($kind, $this->application->getKind());

        $subType = new SubType();

        $this->application->setSubType($subType);
        $this->assertEquals($subType, $this->application->getSubType());

        $terms = new Terms();

        $this->application->setTerms($terms);
        $this->assertEquals($terms, $this->application->getTerms());

        $this->application->setPostcode('5754DW');
        $this->assertEquals('5754DW', $this->application->getPostcode());

        $this->application->setCountry('NL');
        $this->assertEquals('NL', $this->application->getCountry());

        $this->application->setDistance(15);
        $this->assertEquals(15, $this->application->getDistance());

        $this->application->setMinPrice(150000);
        $this->assertEquals(150000, $this->application->getMinPrice());

        $this->application->setMaxPrice(450000);
        $this->assertEquals(450000, $this->application->getMaxPrice());

        $this->application->setRooms(3);
        $this->assertEquals(3, $this->application->getRooms());

        $this->application->setActive(true);
        $this->assertTrue($this->application->getActive());
    }
}
