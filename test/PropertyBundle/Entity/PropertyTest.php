<?php
declare(strict_types = 1);

namespace Tests\PropertyBundle\Entity;

use AgentBundle\Entity\Agent;
use ClientBundle\Entity\Client;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Details;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\Property;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;

/**
 *  Property Test
 */
class PropertyTest extends TestCase
{
    /**
     * @var Property
     */
    private $property;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->property = new Property();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->property->getId());

        $kind = new Kind();

        $this->property->setKind($kind);
        $this->assertEquals($kind, $this->property->getKind());

        $agent = new Agent();

        $this->property->setAgent($agent);
        $this->assertEquals($agent, $this->property->getAgent());

        $client = new Client();

        $this->property->setClient($client);
        $this->assertEquals($client, $this->property->getClient());

        $terms = new Terms();

        $this->property->setTerms($terms);
        $this->assertEquals($terms, $this->property->getTerms());

        $subType = new SubType();

        $this->property->setSubType($subType);
        $this->assertEquals($subType, $this->property->getSubType());

        $details = new Details();

        $this->property->setDetails($details);
        $this->assertEquals($details, $this->property->getDetails());

        $this->property->setOnline(true);
        $this->assertTrue($this->property->isOnline());

        $this->property->setStreet('Dalkeith Street');
        $this->assertEquals('Dalkeith Street', $this->property->getStreet());

        $this->property->setHouseNumber('3');
        $this->assertEquals('3', $this->property->getHouseNumber());

        $this->property->setPostcode('EH15 2HP');
        $this->assertEquals('EH15 2HP', $this->property->getPostcode());

        $this->property->setCity('Edinburgh');
        $this->assertEquals('Edinburgh', $this->property->getCity());

        $this->property->setCountry('GB');
        $this->assertEquals('GB', $this->property->getCountry());

        $this->property->setPrice(725000);
        $this->assertEquals(725000, $this->property->getPrice());

        $this->property->setSoldPrice(725000);
        $this->assertEquals(725000, $this->property->getSoldPrice());

        $this->property->setLat('55.948368');
        $this->assertEquals('55.948368', $this->property->getLat());

        $this->property->setLng('-3.101990');
        $this->assertEquals('-3.101990', $this->property->getLng());

        $this->property->setEspc(false);
        $this->assertFalse($this->property->isEspc());

        $this->property->setArchived(false);
        $this->assertFalse($this->property->isArchived());
    }
}
