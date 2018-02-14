<?php
declare(strict_types = 1);

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\Buyer;
use AgentBundle\Entity\Surveyor;
use ClientBundle\Entity\Surveys;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Surveys Test
 */
class SurveysTest extends TestCase
{
    /**
     * @var Surveys
     */
    private $surveys;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->surveys = new Surveys();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->surveys->getId());

        $surveyor = new Surveyor();

        $this->surveys->setSurveyor($surveyor);
        $this->assertEquals($surveyor, $this->surveys->getSurveyor());

        $buyer = new Buyer();

        $this->surveys->setBuyer($buyer);
        $this->assertEquals($buyer, $this->surveys->getBuyer());

        $property = new Property();

        $this->surveys->setProperty($property);
        $this->assertEquals($property, $this->surveys->getProperty());

        $datetime = new \DateTime();

        $this->surveys->setDatetime($datetime);
        $this->assertEquals($datetime, $this->surveys->getDatetime());

        $this->surveys->setNotes('notes');
        $this->assertEquals('notes', $this->surveys->getNotes());

        $created = new \DateTime();

        $this->surveys->setCreated($created);
        $this->assertEquals($created, $this->surveys->getCreated());

        $this->surveys->setUpdated(null);
        $this->assertNull($this->surveys->getUpdated());
    }
}
