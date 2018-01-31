<?php
declare(strict_types=1);

namespace Tests\AlertBundle\Service;

use AgentBundle\Entity\AgentGroup;
use AlertBundle\Entity\Applicant;
use PHPUnit\Framework\TestCase;

/**
 *  Applicant Service Test
 */
class ApplicantServiceTest extends TestCase
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

    public function testCreateApplicant()
    {
        $agentGroup = new AgentGroup();

        $this->applicant->setAgentGroup($agentGroup);
        $this->applicant->setName('Iain Anderson');
        $this->applicant->setEmail('iain@datacomputerservices.co.uk');
        $this->applicant->setPhone('');
        $this->applicant->setCountry('GB');
        $this->applicant->setActive(true);
        $this->applicant->setProtection(false);

        $this->assertEquals($agentGroup, $this->applicant->getAgentGroup());
        $this->assertEquals('Iain Anderson', $this->applicant->getName());
        $this->assertEquals('iain@datacomputerservices.co.uk', $this->applicant->getEmail());
        $this->assertEquals('', $this->applicant->getPhone());
        $this->assertEquals('GB', $this->applicant->getCountry());
        $this->assertInternalType('bool', $this->applicant->getActive());
        $this->assertEquals(true, $this->applicant->getActive());
        $this->assertInternalType('bool', $this->applicant->getProtection());
        $this->assertEquals(false, $this->applicant->getProtection());
    }
}
