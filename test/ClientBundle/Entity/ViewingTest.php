<?php
declare(strict_types = 1);

namespace Test\ClientBundle\Entity;

use ClientBundle\Entity\Buyer;
use ClientBundle\Entity\Viewing;
use AuthenticationBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Viewing Test
 */
class ViewingTest extends TestCase
{
    /**
     * @var Viewing
     */
    private $viewing;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->viewing = new Viewing();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->viewing->getId());

        $buyer = new Buyer();

        $this->viewing->setBuyer($buyer);
        $this->assertEquals($buyer, $this->viewing->getBuyer());

        $property = new Property();

        $this->viewing->setProperty($property);
        $this->assertEquals($property, $this->viewing->getProperty());

        $start = new \DateTime();

        $this->viewing->setStart($start);
        $this->assertEquals($start, $this->viewing->getStart());

        $end = new \DateTime();

        $this->viewing->setEnd($end);
        $this->assertEquals($end, $this->viewing->getEnd());

        $this->viewing->setConfirmation(true);
        $this->assertTrue($this->viewing->getConfirmation());

        $this->viewing->setFeedback('feedback');
        $this->assertEquals('feedback', $this->viewing->getFeedback());

        $this->viewing->setOpenViewing(false);
        $this->assertFalse($this->viewing->getOpenViewing());

        $this->viewing->setWeekly(false);
        $this->assertFalse($this->viewing->getWeekly());

        $staff = new User();

        $this->viewing->setStaff($staff);
        $this->assertEquals($staff, $this->viewing->getStaff());

        $created = new \DateTime();

        $this->viewing->setCreated($created);
        $this->assertEquals($created, $this->viewing->getCreated());

        $this->viewing->setUpdated(null);
        $this->assertNull($this->viewing->getUpdated());
    }
}
