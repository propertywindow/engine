<?php
declare(strict_types=1);

namespace Tests\ConversationBundle\Service;

use ConversationBundle\Entity\Notification;
use PHPUnit\Framework\TestCase;

/**
 *  Notification Service Test
 */
class NotificationServiceTest extends TestCase
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

    public function testCreateConversation()
    {
        $start = \DateTime::createFromFormat("Y-m-d H:i:s", '2017-11-01 10:00:00');

        $this->notification->setType('info');
        $this->notification->setLabel('label');
        $this->notification->setContent('Test notification');
        $this->notification->setStart($start);
        $this->notification->setEnd();
        $this->notification->setImportant(true);
        $this->notification->setRemovable(false);
        $this->notification->setVisible(true);


        $this->assertEquals('info', $this->notification->getType());
        $this->assertEquals('label', $this->notification->getLabel());
        $this->assertEquals('Test notification', $this->notification->getContent());
        $this->assertEquals($start, $this->notification->getStart());
        $this->assertEquals(null, $this->notification->getEnd());
        $this->assertEquals(true, $this->notification->isImportant());
        $this->assertEquals(false, $this->notification->isRemovable());
        $this->assertEquals(true, $this->notification->isVisible());
    }
}
