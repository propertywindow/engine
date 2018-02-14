<?php
declare(strict_types=1);

namespace Test\AgentBundle\Entity;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Surveyor;
use PHPUnit\Framework\TestCase;

/**
 *  Surveyor Test
 */
class SurveyorTest extends TestCase
{
    /**
     * @var Surveyor
     */
    private $surveyor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->surveyor = new Surveyor();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->surveyor->getId());

        $agent = new Agent();

        $this->surveyor->setAgent($agent);
        $this->assertEquals($agent, $this->surveyor->getAgent());

        $this->surveyor->setName('Agency');
        $this->assertEquals('Agency', $this->surveyor->getName());

        $this->surveyor->setStreet('Portobello High Street');
        $this->assertEquals('Portobello High Street', $this->surveyor->getStreet());

        $this->surveyor->setHouseNumber('27');
        $this->assertEquals('27', $this->surveyor->getHouseNumber());

        $this->surveyor->setPostcode('EH15 1DE');
        $this->assertEquals('EH15 1DE', $this->surveyor->getPostcode());

        $this->surveyor->setCity('Edinburgh');
        $this->assertEquals('Edinburgh', $this->surveyor->getCity());

        $this->surveyor->setCountry('GB');
        $this->assertEquals('GB', $this->surveyor->getCountry());

        $this->surveyor->setEmail('info@propertywindow.com');
        $this->assertEquals('info@propertywindow.com', $this->surveyor->getEmail());

        $this->surveyor->setPhone('01316571666');
        $this->assertEquals('01316571666', $this->surveyor->getPhone());

        $this->surveyor->setFax('');
        $this->assertEmpty($this->surveyor->getFax());

        $created = new \DateTime();

        $this->surveyor->setCreated($created);
        $this->assertEquals($created, $this->surveyor->getCreated());

        $this->surveyor->setUpdated(null);
        $this->assertNull($this->surveyor->getUpdated());
    }
}
