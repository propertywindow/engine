<?php
declare(strict_types = 1);

namespace Test\ConversationBundle\Entity;

use ConversationBundle\Entity\Mailbox;
use PHPUnit\Framework\TestCase;

/**
 *  Mailbox Test
 */
class MailboxTest extends TestCase
{
    /**
     * @var Mailbox
     */
    private $mailbox;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->mailbox = new Mailbox();
    }

    public function testGetterAndSetter()
    {
        $this->mailbox->setId(1);
        $this->assertEquals(1, $this->mailbox->getId());

        $this->mailbox->setName('mailbox');
        $this->assertEquals('mailbox', $this->mailbox->getName());

        $this->mailbox->setUnread(5);
        $this->assertEquals(5, $this->mailbox->getUnread());

        $created = new \DateTime();

        $this->mailbox->setCreated($created);
        $this->assertEquals($created, $this->mailbox->getCreated());

        $this->mailbox->setUpdated(null);
        $this->assertNull($this->mailbox->getUpdated());
    }
}
