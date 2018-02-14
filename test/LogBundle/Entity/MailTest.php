<?php
declare(strict_types=1);

namespace Test\LogBundle\Entity;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use LogBundle\Entity\Mail;
use PHPUnit\Framework\TestCase;

/**
 *  Mail Test
 */
class MailTest extends TestCase
{
    /**
     * @var Mail
     */
    private $mail;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->mail = new Mail();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->mail->getId());

        $user = new User();

        $this->mail->setSender($user);
        $this->assertEquals($user, $this->mail->getSender());

        $agent = new Agent();

        $this->mail->setAgent($agent);
        $this->assertEquals($agent, $this->mail->getAgent());

        $this->mail->setRecipient('marc@propertywindow.nl');
        $this->assertEquals('marc@propertywindow.nl', $this->mail->getRecipient());

        $this->mail->setSubject('subject');
        $this->assertEquals('subject', $this->mail->getSubject());

        $created = new \DateTime();

        $this->mail->setCreated($created);
        $this->assertEquals($created, $this->mail->getCreated());
    }
}
