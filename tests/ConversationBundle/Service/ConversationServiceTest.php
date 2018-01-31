<?php
declare(strict_types=1);

namespace Tests\ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use ConversationBundle\Entity\Conversation;
use PHPUnit\Framework\TestCase;

/**
 *  Conversation Service Test
 */
class ConversationServiceTest extends TestCase
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

    public function testCreateConversation()
    {
        $author    = new User();
        $recipient = new User();

        $this->conversation->setAuthor($author);
        $this->conversation->setRecipient($recipient);

        $this->assertEquals($author, $this->conversation->getAuthor());
        $this->assertEquals($recipient, $this->conversation->getRecipient());
    }
}
