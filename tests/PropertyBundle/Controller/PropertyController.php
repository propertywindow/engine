<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Controller;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Client;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\Property;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;
use PropertyBundle\Exceptions\PropertyNotFoundException;
use PropertyBundle\Service\PropertyService;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Property Controller Test
 */
class PropertyController extends TestCase
{
    /**
     * @var PropertyService|PHPUnit_Framework_MockObject_MockObject
     */
    private $propertyServiceMock;

    /**
     * @var PropertyController|PHPUnit_Framework_MockObject_MockObject
     */
    private $propertyControllerMock;

    protected function setUp()
    {
        $this->propertyServiceMock = $this->getMockBuilder(PropertyService::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();

        $this->propertyControllerMock = new PropertyController(
            $this->propertyServiceMock
        );
    }

    protected function tearDown()
    {
        $this->propertyServiceMock    = null;
        $this->propertyControllerMock = null;
    }

    /**
     * @dataProvider getAllActionDataProvider
     */
    public function testGetAllProperties($properties)
    {
        $agent = new Agent();

        $this->propertyServiceMock
            ->expects($this->once())
            ->method('listProperties')
            ->willReturn($properties);

        $result = $this->propertyServiceMock->listProperties($agent);

        $response = new Response(json_encode($properties));

        $this->assertEquals($response, $result);
    }

    /**
     * @throws PropertyNotFoundException
     */
    public function testDeleteProperty()
    {
        $id = 1;

        $this->propertyServiceMock
            ->expects($this->once())
            ->method('deleteProperty')
            ->with($id);

        $result = $this->propertyServiceMock->deleteProperty($id);

        $response = new Response();

        $this->assertEquals($response, $result);
    }

    /**
     * @return array
     */
    public function getAllActionDataProvider()
    {
        $kind    = new Kind();
        $agent   = new Agent();
        $client  = new Client();
        $terms   = new Terms();
        $subtype = new SubType();

        $p0          = [];
        $properties0 = [$p0];

        $property1 = new Property();
        $property1->setKind($kind);
        $property1->setAgent($agent);
        $property1->setClient($client);
        $property1->setTerms($terms);
        $property1->setSubType($subtype);
        $property1->setOnline(true);
        $property1->setStreet('Dalkeith Street');
        $property1->setHouseNumber('3');
        $property1->setPostcode('EH15 2HP');
        $property1->setCity('Edinburgh');
        $property1->setCountry('GB');
        $property1->setPrice(725000);
        $property1->setLat(55.948368);
        $property1->setLng(-3.101990);
        $property1->setEspc(false);
        $property1->setArchived(false);
        $properties1 = [$property1];

        $property2 = new Property();
        $property2->setKind($kind);
        $property2->setAgent($agent);
        $property2->setClient($client);
        $property2->setTerms($terms);
        $property2->setSubType($subtype);
        $property2->setOnline(true);
        $property2->setStreet('Dalkeith Street');
        $property2->setHouseNumber('3');
        $property2->setPostcode('EH15 2HP');
        $property2->setCity('Edinburgh');
        $property2->setCountry('GB');
        $property2->setPrice(725000);
        $property2->setLat(55.948368);
        $property2->setLng(-3.101990);
        $property2->setEspc(false);
        $property2->setArchived(false);
        $properties2 = [$property1, $property2];

        return [
            [$properties0],
            [$properties1],
            [$properties2],
        ];
    }
}
