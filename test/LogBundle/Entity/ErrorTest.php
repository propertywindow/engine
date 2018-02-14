<?php
declare(strict_types = 1);

namespace Tests\LogBundle\Entity;

use AuthenticationBundle\Entity\User;
use LogBundle\Entity\Error;
use PHPUnit\Framework\TestCase;

/**
 *  Error Test
 */
class ErrorTest extends TestCase
{
    /**
     * @var Error
     */
    private $error;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->error = new Error();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->error->getId());

        $user = new User();

        $this->error->setUser($user);
        $this->assertEquals($user, $this->error->getUser());

        $this->error->setMethod('action');
        $this->assertEquals('action', $this->error->getMethod());

        $this->error->setMessage('category');
        $this->assertEquals('category', $this->error->getMessage());

        $this->error->setParameters([]);
        $this->assertEmpty($this->error->getParameters());

        $created = new \DateTime();

        $this->error->setCreated($created);
        $this->assertEquals($created, $this->error->getCreated());
    }
}
