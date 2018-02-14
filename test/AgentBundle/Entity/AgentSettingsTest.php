<?php
declare(strict_types = 1);

namespace Tests\AgentBundle\Entity;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\AgentSettings;
use PHPUnit\Framework\TestCase;

/**
 *  AgentSettings Test
 */
class AgentSettingsTest extends TestCase
{
    /**
     * @var AgentSettings
     */
    private $agentSettings;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->agentSettings = new AgentSettings();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->agentSettings->getId());

        $agent = new Agent();

        $this->agentSettings->setAgent($agent);
        $this->assertEquals($agent, $this->agentSettings->getAgent());

        $this->agentSettings->setLanguage('en');
        $this->assertEquals('en', $this->agentSettings->getLanguage());

        $this->agentSettings->setCurrency('GBP');
        $this->assertEquals('GBP', $this->agentSettings->getCurrency());

        $this->agentSettings->setEmailName('Property Window');
        $this->assertEquals('Property Window', $this->agentSettings->getEmailName());

        $this->agentSettings->setEmailAddress('no-reply@propertywindow.nl');
        $this->assertEquals('no-reply@propertywindow.nl', $this->agentSettings->getEmailAddress());

        $this->agentSettings->setIMAPAddress('imap.gmail.com');
        $this->assertEquals('imap.gmail.com', $this->agentSettings->getIMAPAddress());

        $this->agentSettings->setIMAPPort(993);
        $this->assertEquals(993, $this->agentSettings->getIMAPPort());

        $this->agentSettings->setIMAPSecure('SSL');
        $this->assertEquals('SSL', $this->agentSettings->getIMAPSecure());

        $this->agentSettings->setIMAPUsername('propertywindownl');
        $this->assertEquals('propertywindownl', $this->agentSettings->getIMAPUsername());

        $this->agentSettings->setIMAPPassword('password');
        $this->assertEquals('password', $this->agentSettings->getIMAPPassword());

        $this->agentSettings->setSMTPAddress('smtp.gmail.com');
        $this->assertEquals('smtp.gmail.com', $this->agentSettings->getSMTPAddress());

        $this->agentSettings->setSMTPPort(465);
        $this->assertEquals(465, $this->agentSettings->getSMTPPort());

        $this->agentSettings->setSMTPSecure('SSL');
        $this->assertEquals('SSL', $this->agentSettings->getSMTPSecure());

        $this->agentSettings->setSMTPUsername('propertywindownl');
        $this->assertEquals('propertywindownl', $this->agentSettings->getSMTPUsername());

        $this->agentSettings->setSMTPPassword('password');
        $this->assertEquals('password', $this->agentSettings->getSMTPPassword());
    }
}
