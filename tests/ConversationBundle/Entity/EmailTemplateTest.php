<?php
declare(strict_types=1);

namespace Tests\ConversationBundle\Entity;

use AgentBundle\Entity\Agent;
use ConversationBundle\Entity\EmailTemplate;
use ConversationBundle\Entity\EmailTemplateCategory;
use PHPUnit\Framework\TestCase;

/**
 *  EmailTemplate Test
 */
class EmailTemplateTest extends TestCase
{
    /**
     * @var EmailTemplate
     */
    private $emailTemplate;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->emailTemplate = new EmailTemplate();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->emailTemplate->getId());

        $agent = new Agent();

        $this->emailTemplate->setAgent($agent);
        $this->assertEquals($agent, $this->emailTemplate->getAgent());

        $this->emailTemplate->setName('name');
        $this->assertEquals('name', $this->emailTemplate->getName());

        $category = new EmailTemplateCategory();

        $this->emailTemplate->setCategory($category);
        $this->assertEquals($category, $this->emailTemplate->getCategory());

        $this->emailTemplate->setSubject('subject');
        $this->assertEquals('subject', $this->emailTemplate->getSubject());

        $this->emailTemplate->setBodyHTML('html');
        $this->assertEquals('html', $this->emailTemplate->getBodyHTML());

        $this->emailTemplate->setBodyTXT('txt');
        $this->assertEquals('txt', $this->emailTemplate->getBodyTXT());

        $this->emailTemplate->setActive(true);
        $this->assertTrue($this->emailTemplate->getActive());

        $created = new \DateTime();

        $this->emailTemplate->setCreated($created);
        $this->assertEquals($created, $this->emailTemplate->getCreated());

        $this->emailTemplate->setUpdated(null);
        $this->assertNull($this->emailTemplate->getUpdated());
    }
}
