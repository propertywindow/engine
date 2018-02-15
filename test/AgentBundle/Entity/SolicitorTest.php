<?php
declare(strict_types = 1);

namespace Tests\AgentBundle\Entity;

use AgentBundle\Entity\Agency;
use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Solicitor;
use AppBundle\Entity\ContactAddress;
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

        $address = new ContactAddress();

        $this->solicitor->setAddress($address);
        $this->assertEquals($address, $this->solicitor->getAddress());

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
