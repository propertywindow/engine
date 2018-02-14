<?php
declare(strict_types = 1);

namespace Test\AuthenticationBundle\Entity;

use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Entity\UserSettings;
use PHPUnit\Framework\TestCase;

/**
 *  UserSettings Test
 */
class UserSettingsTest extends TestCase
{
    /**
     * @var UserSettings
     */
    private $userSettings;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->userSettings = new UserSettings();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->userSettings->getId());

        $user = new User();

        $this->userSettings->setUser($user);
        $this->assertEquals($user, $this->userSettings->getUser());

        $this->userSettings->setLanguage('en');
        $this->assertEquals('en', $this->userSettings->getLanguage());

        $this->userSettings->setEmailName('Property Window');
        $this->assertEquals('Property Window', $this->userSettings->getEmailName());

        $this->userSettings->setEmailAddress('no-reply@propertywindow.nl');
        $this->assertEquals('no-reply@propertywindow.nl', $this->userSettings->getEmailAddress());

        $this->userSettings->setIMAPAddress('imap.gmail.com');
        $this->assertEquals('imap.gmail.com', $this->userSettings->getIMAPAddress());

        $this->userSettings->setIMAPPort(993);
        $this->assertEquals(993, $this->userSettings->getIMAPPort());

        $this->userSettings->setIMAPSecure('SSL');
        $this->assertEquals('SSL', $this->userSettings->getIMAPSecure());

        $this->userSettings->setIMAPUsername('propertywindownl');
        $this->assertEquals('propertywindownl', $this->userSettings->getIMAPUsername());

        $this->userSettings->setIMAPPassword('password');
        $this->assertEquals('password', $this->userSettings->getIMAPPassword());

        $this->userSettings->setSMTPAddress('smtp.gmail.com');
        $this->assertEquals('smtp.gmail.com', $this->userSettings->getSMTPAddress());

        $this->userSettings->setSMTPPort(465);
        $this->assertEquals(465, $this->userSettings->getSMTPPort());

        $this->userSettings->setSMTPSecure('SSL');
        $this->assertEquals('SSL', $this->userSettings->getSMTPSecure());

        $this->userSettings->setSMTPUsername('propertywindownl');
        $this->assertEquals('propertywindownl', $this->userSettings->getSMTPUsername());

        $this->userSettings->setSMTPPassword('password');
        $this->assertEquals('password', $this->userSettings->getSMTPPassword());
    }
}
