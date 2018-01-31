<?php
declare(strict_types=1);

namespace Tests\AgentBundle\Service;

use AgentBundle\Entity\Agency;
use AgentBundle\Entity\Agent;
use PHPUnit\Framework\TestCase;

/**
 *  Agency Service Test
 */
class AgencyServiceTest extends TestCase
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

    public function testCreateAgency()
    {
        $agentGroup = new Agent();

        $this->agency->setAgent($agentGroup);
        $this->agency->setName('Agency');
        $this->agency->setStreet('Portobello High Street');
        $this->agency->setHouseNumber('27');
        $this->agency->setPostcode('EH15 1DE');
        $this->agency->setCity('Edinburgh');
        $this->agency->setCountry('GB');
        $this->agency->setEmail('info@propertywindow.com');
        $this->agency->setPhone('01316571666');
        $this->agency->setFax('');

        $this->assertEquals($agentGroup, $this->agency->getAgent());
        $this->assertEquals('Agency', $this->agency->getName());
        $this->assertEquals('Portobello High Street', $this->agency->getStreet());
        $this->assertEquals('27', $this->agency->getHouseNumber());
        $this->assertEquals('EH15 1DE', $this->agency->getPostcode());
        $this->assertEquals('Edinburgh', $this->agency->getCity());
        $this->assertEquals('GB', $this->agency->getCountry());
        $this->assertEquals('info@propertywindow.com', $this->agency->getEmail());
        $this->assertEquals('01316571666', $this->agency->getPhone());
        $this->assertEquals('', $this->agency->getFax());
    }
}
