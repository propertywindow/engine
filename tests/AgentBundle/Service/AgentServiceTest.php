<?php
declare(strict_types=1);

namespace Tests\AgentBundle\Service;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\AgentGroup;
use PHPUnit\Framework\TestCase;

/**
 *  Agent Service Test
 */
class AgentServiceTest extends TestCase
{
    /**
     * @var Agent
     */
    private $agent;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->agent = new Agent();
    }

    public function testCreateAgent()
    {
        $agentGroup = new AgentGroup();

        $this->agent->setAgentGroup($agentGroup);
        $this->agent->setOffice('Edinburgh');
        $this->agent->setStreet('Portobello High Street');
        $this->agent->setHouseNumber('27');
        $this->agent->setPostcode('EH15 1DE');
        $this->agent->setCity('Edinburgh');
        $this->agent->setCountry('GB');
        $this->agent->setEmail('info@propertywindow.com');
        $this->agent->setPhone('01316571666');
        $this->agent->setPropertyLimit(200);
        $this->agent->setEspc(false);
        $this->agent->setArchived(false);
        $this->agent->setUserId(3);

        $this->assertEquals($agentGroup, $this->agent->getAgentGroup());
        $this->assertEquals('Edinburgh', $this->agent->getOffice());
        $this->assertEquals('Portobello High Street', $this->agent->getStreet());
        $this->assertEquals('27', $this->agent->getHouseNumber());
        $this->assertEquals('EH15 1DE', $this->agent->getPostcode());
        $this->assertEquals('Edinburgh', $this->agent->getCity());
        $this->assertEquals('GB', $this->agent->getCountry());
        $this->assertEquals('info@propertywindow.com', $this->agent->getEmail());
        $this->assertEquals('01316571666', $this->agent->getPhone());
        $this->assertEquals(200, $this->agent->getPropertyLimit());
        $this->assertEquals(false, $this->agent->getEspc());
        $this->assertEquals(false, $this->agent->getArchived());
        $this->assertEquals(3, $this->agent->getUserId());
    }
}
