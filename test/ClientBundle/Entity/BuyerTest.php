<?php
declare(strict_types = 1);

namespace Test\ClientBundle\Entity;

use ClientBundle\Entity\Buyer;
use AgentBundle\Entity\Solicitor;
use PHPUnit\Framework\TestCase;

/**
 *  Buyer Test
 */
class BuyerTest extends TestCase
{
    /**
     * @var Buyer
     */
    private $buyer;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->buyer = new Buyer();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->buyer->getId());

        $solicitor = new Solicitor();

        $this->buyer->setSolicitor($solicitor);
        $this->assertEquals($solicitor, $this->buyer->getSolicitor());

        $this->buyer->setFirstName('Marc');
        $this->assertEquals('Marc', $this->buyer->getFirstName());

        $this->buyer->setLastName('Geurts');
        $this->assertEquals('Geurts', $this->buyer->getLastName());

        $this->buyer->setStreet('Portobello High Street');
        $this->assertEquals('Portobello High Street', $this->buyer->getStreet());

        $this->buyer->setHouseNumber('27');
        $this->assertEquals('27', $this->buyer->getHouseNumber());

        $this->buyer->setPostcode('EH15 1DE');
        $this->assertEquals('EH15 1DE', $this->buyer->getPostcode());

        $this->buyer->setCity('Edinburgh');
        $this->assertEquals('Edinburgh', $this->buyer->getCity());

        $this->buyer->setCountry('GB');
        $this->assertEquals('GB', $this->buyer->getCountry());

        $this->buyer->setEmail('info@propertywindow.com');
        $this->assertEquals('info@propertywindow.com', $this->buyer->getEmail());

        $this->buyer->setPhone('01316571666');
        $this->assertEquals('01316571666', $this->buyer->getPhone());

        $created = new \DateTime();

        $this->buyer->setCreated($created);
        $this->assertEquals($created, $this->buyer->getCreated());

        $this->buyer->setUpdated(null);
        $this->assertNull($this->buyer->getUpdated());
    }
}
