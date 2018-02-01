<?php
declare(strict_types=1);

namespace Tests\AgentBundle\Entity;

use AgentBundle\Entity\Buyer;
use AgentBundle\Entity\Interest;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Interest Test
 */
class InterestTest extends TestCase
{
    /**
     * @var Interest
     */
    private $interest;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->interest = new Interest();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->interest->getId());

        $property = new Property();

        $this->interest->setProperty($property);
        $this->assertEquals($property, $this->interest->getProperty());

        $buyer = new Buyer();

        $this->interest->setBuyer($buyer);
        $this->assertEquals($buyer, $this->interest->getBuyer());

        $created = new \DateTime();

        $this->interest->setCreated($created);
        $this->assertEquals($created, $this->interest->getCreated());

        $this->interest->setUpdated(null);
        $this->assertNull($this->interest->getUpdated());
    }
}
