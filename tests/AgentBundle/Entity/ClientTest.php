<?php
declare(strict_types=1);

namespace Tests\AgentBundle\Entity;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Client;
use AuthenticationBundle\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 *  Client Test
 */
class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->client = new Client();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->client->getId());

        $agent = new Agent();

        $this->client->setAgent($agent);
        $this->assertEquals($agent, $this->client->getAgent());

        $user = new User();

        $this->client->setUser($user);
        $this->assertEquals($user, $this->client->getUser());

        $this->client->setTransparency(true);
        $this->assertTrue($this->client->getTransparency());

        $created = new \DateTime();

        $this->client->setCreated($created);
        $this->assertEquals($created, $this->client->getCreated());

        $this->client->setUpdated(null);
        $this->assertNull($this->client->getUpdated());
    }
}
