<?php
declare(strict_types = 1);

namespace Tests\AgentBundle\Entity;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Surveyor;
use AppBundle\Entity\ContactAddress;
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

    public function testAddress()
    {
        $address = new ContactAddress();

        $this->surveyor->setAddress($address);
        $this->assertEquals($address, $this->surveyor->getAddress());
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->surveyor->getId());

        $agent = new Agent();

        $this->surveyor->setAgent($agent);
        $this->assertEquals($agent, $this->surveyor->getAgent());

        $this->surveyor->setName('Agency');
        $this->assertEquals('Agency', $this->surveyor->getName());

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
