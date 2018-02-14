<?php
declare(strict_types = 1);

namespace Tests\LogBundle\Entity;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use LogBundle\Entity\Login;
use PHPUnit\Framework\TestCase;

/**
 *  Login Test
 */
class LoginTest extends TestCase
{
    /**
     * @var Login
     */
    private $login;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->login = new Login();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->login->getId());

        $user = new User();

        $this->login->setUser($user);
        $this->assertEquals($user, $this->login->getUser());

        $agent = new Agent();

        $this->login->setAgent($agent);
        $this->assertEquals($agent, $this->login->getAgent());

        $this->login->setIp('192.168.100.10');
        $this->assertEquals('192.168.100.10', $this->login->getIp());

        $created = new \DateTime();

        $this->login->setCreated($created);
        $this->assertEquals($created, $this->login->getCreated());
    }
}
