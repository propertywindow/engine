<?php
declare(strict_types = 1);

namespace Tests\AgentBundle\Entity;

use AgentBundle\Entity\Agency;
use AgentBundle\Entity\Agent;
use AppBundle\Entity\ContactAddress;
use PHPUnit\Framework\TestCase;

/**
 *  Agency Test
 */
class AgencyTest extends TestCase
{
    /**
     * @var Agency
     */
    private $agency;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->agency = new Agency();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->agency->getId());

        $agent = new Agent();

        $this->agency->setAgent($agent);
        $this->assertEquals($agent, $this->agency->getAgent());

        $this->agency->setName('Agency');
        $this->assertEquals('Agency', $this->agency->getName());

        $address = new ContactAddress();

        $this->agency->setAddress($address);
        $this->assertEquals($address, $this->agency->getAddress());

        $this->agency->setEmail('info@propertywindow.com');
        $this->assertEquals('info@propertywindow.com', $this->agency->getEmail());

        $this->agency->setPhone('01316571666');
        $this->assertEquals('01316571666', $this->agency->getPhone());

        $this->agency->setFax('');
        $this->assertEmpty($this->agency->getFax());

        $created = new \DateTime();

        $this->agency->setCreated($created);
        $this->assertEquals($created, $this->agency->getCreated());

        $this->agency->setUpdated(null);
        $this->assertNull($this->agency->getUpdated());
    }
}
