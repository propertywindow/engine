<?php
declare(strict_types=1);

namespace Tests\AgentBundle\Entity;

use AgentBundle\Entity\AgentGroup;
use PHPUnit\Framework\TestCase;

/**
 *  Agent AgentGroup
 */
class AgentGroupTest extends TestCase
{
    /**
     * @var AgentGroup
     */
    private $agentGroup;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->agentGroup = new AgentGroup();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->agentGroup->getId());

        $this->agentGroup->setName('Agent Group');
        $this->assertEquals('Agent Group', $this->agentGroup->getName());
    }
}
