<?php
declare(strict_types=1);

namespace Tests\AlertBundle\Entity;

use AgentBundle\Entity\AgentGroup;
use AlertBundle\Entity\Applicant;
use PHPUnit\Framework\TestCase;

/**
 *  Applicant Test
 */
class ApplicantTest extends TestCase
{
    /**
     * @var Applicant
     */
    private $applicant;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->applicant = new Applicant();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->applicant->getId());

        $agentGroup = new AgentGroup();

        $this->applicant->setAgentGroup($agentGroup);
        $this->assertEquals($agentGroup, $this->applicant->getAgentGroup());

        $this->applicant->setName('Iain Anderson');
        $this->assertEquals('Iain Anderson', $this->applicant->getName());

        $this->applicant->setEmail('iain@datacomputerservices.co.uk');
        $this->assertEquals('iain@datacomputerservices.co.uk', $this->applicant->getEmail());

        $this->applicant->setPhone('');
        $this->assertEmpty($this->applicant->getPhone());

        $this->applicant->setCountry('GB');
        $this->assertEquals('GB', $this->applicant->getCountry());

        $this->applicant->setActive(true);
        $this->assertTrue($this->applicant->getActive());

        $this->applicant->setProtection(false);
        $this->assertFalse($this->applicant->getProtection());
    }
}
