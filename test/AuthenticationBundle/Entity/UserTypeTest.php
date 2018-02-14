<?php
declare(strict_types = 1);

namespace Tests\AuthenticationBundle\Entity;

use AuthenticationBundle\Entity\UserType;
use PHPUnit\Framework\TestCase;

/**
 *  UserType Test
 */
class UserTypeTest extends TestCase
{
    /**
     * @var UserType
     */
    private $userType;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->userType = new UserType();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->userType->getId());

        $this->userType->setEn('colleague');
        $this->assertEquals('colleague', $this->userType->getEn());

        $this->userType->setNl('collega');
        $this->assertEquals('collega', $this->userType->getNl());

        $this->userType->setVisible(true);
        $this->assertTrue($this->userType->getVisible());

        $created = new \DateTime();

        $this->userType->setCreated($created);
        $this->assertEquals($created, $this->userType->getCreated());

        $this->userType->setUpdated(null);
        $this->assertNull($this->userType->getUpdated());
    }
}
