<?php
declare(strict_types = 1);

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\ContactAddress;

/**
 *  ContactAddress Test
 */
class ContactAddressTest extends TestCase
{
    /**
     * @var ContactAddress
     */
    private $address;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->address = new ContactAddress();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->address->getId());

        $this->address->setStreet('Portobello High Street');
        $this->assertEquals('Portobello High Street', $this->address->getStreet());

        $this->address->setHouseNumber('27');
        $this->assertEquals('27', $this->address->getHouseNumber());

        $this->address->setPostcode('EH15 1DE');
        $this->assertEquals('EH15 1DE', $this->address->getPostcode());

        $this->address->setCity('Edinburgh');
        $this->assertEquals('Edinburgh', $this->address->getCity());

        $this->address->setCountry('GB');
        $this->assertEquals('GB', $this->address->getCountry());
    }
}
