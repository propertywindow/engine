<?php
declare(strict_types = 1);

namespace Test\ConversationBundle\Entity;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Message;
use PHPUnit\Framework\TestCase;

/**
 *  Message Test
 */
class MessageTest extends TestCase
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->message = new Message();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->message->getId());

        $author = new User();

        $this->message->setAuthor($author);
        $this->assertEquals($author, $this->message->getAuthor());

        $recipient = new User();

        $this->message->setRecipient($recipient);
        $this->assertEquals($recipient, $this->message->getRecipient());

        $this->message->setMessage('message');
        $this->assertEquals('message', $this->message->getMessage());

        $this->message->setType('');
        $this->assertEmpty($this->message->getType());

        $this->message->setSeen(true);
        $this->assertTrue($this->message->getSeen());

        $created = new \DateTime();

        $this->message->setCreated($created);
        $this->assertEquals($created, $this->message->getCreated());

        $this->message->setUpdated(null);
        $this->assertNull($this->message->getUpdated());
    }
}
