<?php declare(strict_types=1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Settings;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadSettingsData
 * @package AppBundle\DataFixtures\ORM
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
        $settings->setSlackChannel('#errors');
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
