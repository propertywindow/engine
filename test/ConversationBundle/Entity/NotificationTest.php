<?php
declare(strict_types = 1);

namespace Tests\ConversationBundle\Entity;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Notification;
use PHPUnit\Framework\TestCase;

/**
 *  Notification Test
 */
class NotificationTest extends TestCase
{
    /**
     * @var Notification
     */
    private $notification;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->notification = new Notification();
    }

    public function testGetterAndSetter()
    {
        $this->notification->setId(1);
        $this->assertEquals(1, $this->notification->getId());

        $user = new User();

        $this->notification->setUser($user);
        $this->assertEquals($user, $this->notification->getUser());

        $this->notification->setContent('Test notification');
        $this->assertEquals('Test notification', $this->notification->getContent());

        $this->notification->setLabel('label');
        $this->assertEquals('label', $this->notification->getLabel());

        $this->notification->setType('info');
        $this->assertEquals('info', $this->notification->getType());

        $start = new \DateTime();

        $this->notification->setStart($start);
        $this->assertEquals($start, $this->notification->getStart());

        $this->notification->setEnd();
        $this->assertNull($this->notification->getEnd());

        $this->notification->setImportant(true);
        $this->assertTrue($this->notification->isImportant());

        $this->notification->setRemovable(false);
        $this->assertFalse($this->notification->isRemovable());

        $this->notification->setVisible(true);
        $this->assertTrue($this->notification->isVisible());

        $this->notification->markForEveryone();
        $this->assertTrue($this->notification->isForEveryone());
    }
}
