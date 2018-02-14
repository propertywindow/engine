<?php
declare(strict_types=1);

namespace Test\LogBundle\Entity;

use LogBundle\Entity\Traffic;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Traffic Test
 */
class TrafficTest extends TestCase
{
    /**
     * @var Traffic
     */
    private $traffic;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->traffic = new Traffic();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->traffic->getId());

        $user = new Property();

        $this->traffic->setProperty($user);
        $this->assertEquals($user, $this->traffic->getProperty());

        $this->traffic->setIp('192.168.100.10');
        $this->assertEquals('192.168.100.10', $this->traffic->getIp());

        $this->traffic->setBrowser('browser');
        $this->assertEquals('browser', $this->traffic->getBrowser());

        $this->traffic->setLocation('location');
        $this->assertEquals('location', $this->traffic->getLocation());

        $this->traffic->setReferrer('');
        $this->assertEmpty($this->traffic->getReferrer());

        $created = new \DateTime();

        $this->traffic->setCreated($created);
        $this->assertEquals($created, $this->traffic->getCreated());
    }
}
