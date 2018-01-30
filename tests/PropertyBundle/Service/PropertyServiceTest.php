<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Service;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Client;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\Property;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;

/**
 *  Property Service Test
 */
class PropertyServiceTest extends TestCase
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

    public function testCreateProperty()
    {
        $kind    = new Kind();
        $agent   = new Agent();
        $client  = new Client();
        $terms   = new Terms();
        $subtype = new SubType();

        $this->property->setKind($kind);
        $this->property->setAgent($agent);
        $this->property->setClient($client);
        $this->property->setTerms($terms);
        $this->property->setSubType($subtype);
        $this->property->setOnline(true);
        $this->property->setStreet('Dalkeith Street');
        $this->property->setHouseNumber('3');
        $this->property->setPostcode('EH15 2HP');
        $this->property->setCity('Edinburgh');
        $this->property->setCountry('GB');
        $this->property->setPrice(725000);
        $this->property->setLat(55.948368);
        $this->property->setLng(-3.101990);
        $this->property->setEspc(false);
        $this->property->setArchived(false);

        $this->assertEquals($kind, $this->property->getKind());
        $this->assertEquals($agent, $this->property->getAgent());
        $this->assertEquals($client, $this->property->getClient());
        $this->assertEquals($terms, $this->property->getTerms());
        $this->assertEquals($subtype, $this->property->getSubType());
        $this->assertEquals('Edinburgh', $this->property->getCity());
        $this->assertInternalType('bool', $this->property->getOnline());
    }
}
