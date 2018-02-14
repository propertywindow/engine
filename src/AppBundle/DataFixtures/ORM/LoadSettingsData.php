<?php
declare(strict_types = 1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Settings;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadSettingsData
 */
class LoadSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $settings = new Settings();
        $settings->setApplicationName('Property Window');
        $settings->setApplicationURL('http://www.propertywindow.nl');
        $settings->setMaxFailedLogin(5);
        $settings->setSlackEnabled(true);
        $settings->setSlackURL('https://hooks.slack.com/services/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');
        $settings->setSlackUsername('Property Window');
        $manager->persist($settings);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}
