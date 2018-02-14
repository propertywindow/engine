<?php
declare(strict_types = 1);

namespace Test\ConversationBundle\Entity;

use ConversationBundle\Entity\EmailTemplateCategory;
use PHPUnit\Framework\TestCase;

/**
 *  EmailTemplateCategory Test
 */
class EmailTemplateCategoryTest extends TestCase
{
    /**
     * @var EmailTemplateCategory
     */
    private $emailTemplateCategory;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->emailTemplateCategory = new EmailTemplateCategory();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->emailTemplateCategory->getId());

        $this->emailTemplateCategory->setEn('Users');
        $this->assertEquals('Users', $this->emailTemplateCategory->getEn());

        $this->emailTemplateCategory->setNl('Gebruikers');
        $this->assertEquals('Gebruikers', $this->emailTemplateCategory->getNl());

        $this->emailTemplateCategory->setActive(true);
        $this->assertTrue($this->emailTemplateCategory->getActive());

        $created = new \DateTime();

        $this->emailTemplateCategory->setCreated($created);
        $this->assertEquals($created, $this->emailTemplateCategory->getCreated());

        $this->emailTemplateCategory->setUpdated(null);
        $this->assertNull($this->emailTemplateCategory->getUpdated());
    }
}
