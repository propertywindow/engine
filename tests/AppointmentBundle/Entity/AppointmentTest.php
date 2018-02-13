<?php
declare(strict_types=1);

namespace Tests\AppointmentBundle\Entity;

use AppointmentBundle\Entity\Appointment;
use ClientBundle\Entity\Buyer;
use AuthenticationBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Appointment Test
 */
class AppointmentTest extends TestCase
{
    /**
     * @var Appointment
     */
    private $appointment;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->appointment = new Appointment();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->appointment->getId());

        $buyer = new Buyer();

        $this->appointment->setBuyer($buyer);
        $this->assertEquals($buyer, $this->appointment->getBuyer());

        $property = new Property();

        $this->appointment->setProperty($property);
        $this->assertEquals($property, $this->appointment->getProperty());

        $user = new User();

        $this->appointment->setUser($user);
        $this->assertEquals($user, $this->appointment->getUser());

        $this->appointment->setSubject('subject');
        $this->assertEquals('subject', $this->appointment->getSubject());

        $this->appointment->setDescription('description');
        $this->assertEquals('description', $this->appointment->getDescription());

        $start = new \DateTime();

        $this->appointment->setStart($start);
        $this->assertEquals($start, $this->appointment->getStart());

        $end = new \DateTime();

        $this->appointment->setEnd($end);
        $this->assertEquals($end, $this->appointment->getEnd());

        $created = new \DateTime();

        $this->appointment->setCreated($created);
        $this->assertEquals($created, $this->appointment->getCreated());

        $this->appointment->setUpdated(null);
        $this->assertNull($this->appointment->getUpdated());
    }
}
