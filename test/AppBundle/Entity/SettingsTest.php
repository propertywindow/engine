<?php
declare(strict_types = 1);

namespace Test\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Settings;

/**
 *  Settings Test
 */
class SettingsTest extends TestCase
{
    /**
     * @var Settings
     */
    private $settings;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->settings = new Settings();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->settings->getId());

        $this->settings->setApplicationName('Property Window');
        $this->assertEquals('Property Window', $this->settings->getApplicationName());

        $this->settings->setApplicationURL('http://www.propertywindow.nl');
        $this->assertEquals('http://www.propertywindow.nl', $this->settings->getApplicationURL());

        $this->settings->setMaxFailedLogin(5);
        $this->assertEquals(5, $this->settings->getMaxFailedLogin());

        $this->settings->setSlackEnabled(true);
        $this->assertTrue($this->settings->getSlackEnabled());

        $this->settings->setSlackURL('url');
        $this->assertEquals('url', $this->settings->getSlackURL());

        $this->settings->setSlackUsername('username');
        $this->assertEquals('username', $this->settings->getSlackUsername());
    }
}
