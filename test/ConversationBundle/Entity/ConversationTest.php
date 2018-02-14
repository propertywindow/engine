<?php
declare(strict_types = 1);

namespace Test\ConversationBundle\Entity;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Conversation;
use PHPUnit\Framework\TestCase;

/**
 *  Conversation Test
 */
class ConversationTest extends TestCase
{
    /**
     * @var Conversation
     */
    private $conversation;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->conversation = new Conversation();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->conversation->getId());

        $author = new User();

        $this->conversation->setAuthor($author);
        $this->assertEquals($author, $this->conversation->getAuthor());

        $recipient = new User();

        $this->conversation->setRecipient($recipient);
        $this->assertEquals($recipient, $this->conversation->getRecipient());

        $created = new \DateTime();

        $this->conversation->setCreated($created);
        $this->assertEquals($created, $this->conversation->getCreated());

        $this->conversation->setUpdated(null);
        $this->assertNull($this->conversation->getUpdated());
    }
}
