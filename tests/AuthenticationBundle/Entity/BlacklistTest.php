<?php
declare(strict_types=1);

namespace Tests\AuthenticationBundle\Entity;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\Blacklist;
use AuthenticationBundle\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 *  Blacklist Test
 */
class BlacklistTest extends TestCase
{
    /**
     * @var Blacklist
     */
    private $blacklist;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->blacklist = new Blacklist();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->blacklist->getId());

        $this->blacklist->setIp('192.168.1.100');
        $this->assertEquals('192.168.1.100', $this->blacklist->getIp());

        $this->blacklist->setAmount(2);
        $this->assertEquals(2, $this->blacklist->getAmount());

        $agent = new Agent();

        $this->blacklist->setAgent($agent);
        $this->assertEquals($agent, $this->blacklist->getAgent());

        $user = new User();

        $this->blacklist->setUser($user);
        $this->assertEquals($user, $this->blacklist->getUser());
    }
}
