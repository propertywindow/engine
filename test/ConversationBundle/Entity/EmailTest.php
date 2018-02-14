<?php
declare(strict_types=1);

namespace Test\ConversationBundle\Entity;

use ConversationBundle\Entity\Email;
use PHPUnit\Framework\TestCase;

/**
 *  Email Test
 */
class EmailTest extends TestCase
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->email = new Email();
    }

    public function testGetterAndSetter()
    {
        $this->email->setId(5);
        $this->assertEquals(5, $this->email->getId());

        $this->email->setSubject('subject');
        $this->assertEquals('subject', $this->email->getSubject());

        $this->email->setMessage('message');
        $this->assertEquals('message', $this->email->getMessage());

        $this->email->setFrom('from');
        $this->assertEquals('from', $this->email->getFrom());

        $date = new \DateTime();

        $this->email->setDate($date);
        $this->assertEquals($date, $this->email->getDate());
    }
}
