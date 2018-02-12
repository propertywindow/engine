<?php
declare(strict_types = 1);

namespace Tests\PropertyBundle\Service;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Client;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Kind;
use PropertyBundle\Entity\Property;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Terms;
use PropertyBundle\Exceptions\PropertyNotFoundException;
use PropertyBundle\Service\PropertyService;

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
        $this->property->setLat('55.948368');
        $this->property->setLng('-3.101990');
        $this->property->setEspc(false);
        $this->property->setArchived(false);

        $propertyRepository = $this->createMock(ObjectRepository::class);

        $propertyRepository->expects($this->any())
                           ->method('find')
                           ->willReturn($this->property);


        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->any())
                      ->method('getRepository')
                      ->willReturn($propertyRepository);

        $propertyService = new PropertyService($entityManager);

        $propertyService->createProperty($this->property);

        $this->assertEquals($kind, $this->property->getKind());
        $this->assertEquals($agent, $this->property->getAgent());
        $this->assertEquals($client, $this->property->getClient());
        $this->assertEquals($terms, $this->property->getTerms());
        $this->assertEquals($subtype, $this->property->getSubType());
        $this->assertTrue($this->property->getOnline());
        $this->assertEquals('Dalkeith Street', $this->property->getStreet());
        $this->assertEquals('3', $this->property->getHouseNumber());
        $this->assertEquals('EH15 2HP', $this->property->getPostcode());
        $this->assertEquals('Edinburgh', $this->property->getCity());
        $this->assertEquals('GB', $this->property->getCountry());
        $this->assertInternalType('int', $this->property->getPrice());
        $this->assertEquals(725000, $this->property->getPrice());
        $this->assertEquals('55.948368', $this->property->getLat());
        $this->assertEquals('-3.101990', $this->property->getLng());
        $this->assertFalse($this->property->isEspc());
        $this->assertFalse($this->property->isArchived());
    }

    public function testUpdateProperty()
    {
        $this->testCreateProperty();

        $propertyRepository = $this->createMock(ObjectRepository::class);

        $propertyRepository->expects($this->any())
                           ->method('find')
                           ->willReturn($this->property);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->any())
                      ->method('getRepository')
                      ->willReturn($propertyRepository);

        $this->assertEquals('Dalkeith Street', $this->property->getStreet());

        $propertyService = new PropertyService($entityManager);

        $this->property->setStreet('Parkside Street');

        $property = $propertyService->updateProperty($this->property);

        $this->assertEquals('Parkside Street', $property->getStreet());
    }

    public function testArchiveProperty()
    {
        $this->testCreateProperty();

        $propertyRepository = $this->createMock(ObjectRepository::class);

        $propertyRepository->expects($this->any())
                           ->method('find')
                           ->willReturn($this->property);


        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->any())
                      ->method('getRepository')
                      ->willReturn($propertyRepository);

        $this->assertEquals(0, $this->property->isArchived());

        $propertyService = new PropertyService($entityManager);

        $property = $propertyService->archiveProperty($this->property);

        $this->assertEquals(1, $property->isArchived());
    }
}
