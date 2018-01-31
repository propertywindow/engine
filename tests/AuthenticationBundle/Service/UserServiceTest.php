<?php
declare(strict_types=1);

namespace Tests\AuthenticationBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Entity\UserType;
use PHPUnit\Framework\TestCase;

/**
 *  User Service Test
 */
class UserServiceTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testCreateUser()
    {
        $agent    = new Agent();
        $userType = new UserType();

        $this->user->setUserType($userType);
        $this->user->setAgent($agent);
        $this->user->setEmail('geurtsmarc@hotmail.com');
        $this->user->setPassword(md5('marc'));
        $this->user->setFirstName('Marc');
        $this->user->setLastName('Geurts');
        $this->user->setStreet('Graafsedijk');
        $this->user->setHouseNumber('19');
        $this->user->setPostcode('5437 NG');
        $this->user->setCity('Beers');
        $this->user->setCountry('NL');
        $this->user->setActive(true);
        $this->user->setAvatar('1/users/1.jpg');

        $this->assertEquals($agent, $this->user->getAgent());
        $this->assertEquals($userType, $this->user->getUserType());
        $this->assertEquals('geurtsmarc@hotmail.com', $this->user->getEmail());
        $this->assertEquals('Marc', $this->user->getFirstName());
        $this->assertEquals('Geurts', $this->user->getLastName());
        $this->assertEquals('Graafsedijk', $this->user->getStreet());
        $this->assertEquals('19', $this->user->getHouseNumber());
        $this->assertEquals('5437 NG', $this->user->getPostcode());
        $this->assertEquals('Beers', $this->user->getCity());
        $this->assertEquals('NL', $this->user->getCountry());
        $this->assertInternalType('bool', $this->user->getActive());
        $this->assertEquals(true, $this->user->getActive());
        $this->assertEquals('1/users/1.jpg', $this->user->getAvatar());
    }
}
