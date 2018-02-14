<?php
declare(strict_types = 1);

namespace Test\AgentBundle\Entity;

use AgentBundle\Entity\Agency;
use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Solicitor;
use PHPUnit\Framework\TestCase;

/**
 *  Solicitor Test
 */
class SolicitorTest extends TestCase
{
    /**
     * @var Solicitor
     */
    private $solicitor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->solicitor = new Solicitor();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->solicitor->getId());

        $agent = new Agent();

        $this->solicitor->setAgent($agent);
        $this->assertEquals($agent, $this->solicitor->getAgent());

        $agency = new Agency();

        $this->solicitor->setAgency($agency);
        $this->assertEquals($agency, $this->solicitor->getAgency());

        $this->solicitor->setName('Property Window');
        $this->assertEquals('Property Window', $this->solicitor->getName());

        $this->solicitor->setStreet('Portobello High Street');
        $this->assertEquals('Portobello High Street', $this->solicitor->getStreet());

        $this->solicitor->setHouseNumber('27');
        $this->assertEquals('27', $this->solicitor->getHouseNumber());

        $this->solicitor->setPostcode('EH15 1DE');
        $this->assertEquals('EH15 1DE', $this->solicitor->getPostcode());

        $this->solicitor->setCity('Edinburgh');
        $this->assertEquals('Edinburgh', $this->solicitor->getCity());

        $this->solicitor->setCountry('GB');
        $this->assertEquals('GB', $this->solicitor->getCountry());

        $this->solicitor->setEmail('iain@propertywindow.com');
        $this->assertEquals('iain@propertywindow.com', $this->solicitor->getEmail());

        $this->solicitor->setPhone('01316571666');
        $this->assertEquals('01316571666', $this->solicitor->getPhone());

        $this->solicitor->setFax('');
        $this->assertEmpty($this->solicitor->getFax());

        $created = new \DateTime();

        $this->solicitor->setCreated($created);
        $this->assertEquals($created, $this->solicitor->getCreated());

        $this->solicitor->setUpdated(null);
        $this->assertNull($this->solicitor->getUpdated());
    }
}
