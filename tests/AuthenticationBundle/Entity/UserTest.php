<?php
declare(strict_types=1);

namespace Tests\AuthenticationBundle\Entity;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Entity\UserType;
use PHPUnit\Framework\TestCase;

/**
 *  Applicant Test
 */
class UserTest extends TestCase
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

    public function testGetterAndSetter()
    {
        $this->assertNull($this->user->getId());

        $agent = new Agent();

        $this->user->setAgent($agent);
        $this->assertEquals($agent, $this->user->getAgent());

        $userType = new UserType();

        $this->user->setUserType($userType);
        $this->assertEquals($userType, $this->user->getUserType());

        $this->user->setEmail('geurtsmarc@hotmail.com');
        $this->assertEquals('geurtsmarc@hotmail.com', $this->user->getEmail());

        $password = md5('marc');

        $this->user->setPassword($password);
        $this->assertEquals($password, $this->user->getPassword());

        $this->user->setFirstName('Marc');
        $this->assertEquals('Marc', $this->user->getFirstName());

        $this->user->setLastName('Geurts');
        $this->assertEquals('Geurts', $this->user->getLastName());

        $this->user->setStreet('Graafsedijk');
        $this->assertEquals('Graafsedijk', $this->user->getStreet());

        $this->user->setHouseNumber('19');
        $this->assertEquals('19', $this->user->getHouseNumber());

        $this->user->setPostcode('5437 NG');
        $this->assertEquals('5437 NG', $this->user->getPostcode());

        $this->user->setCity('Beers');
        $this->assertEquals('Beers', $this->user->getCity());

        $this->user->setCountry('NL');
        $this->assertEquals('NL', $this->user->getCountry());

        $this->user->setActive(true);
        $this->assertTrue($this->user->getActive());

        $this->user->setAvatar('1/users/1.jpg');
        $this->assertEquals('1/users/1.jpg', $this->user->getAvatar());
    }
}
