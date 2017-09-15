<?php declare(strict_types=1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\UserSettings;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadUserSettingsData
 * @package AuthenticationBundle\DataFixtures\ORM
 */
class LoadUserSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Property Window

        for ($i = 1; $i <= 2; $i++) {
            $userSettings = new UserSettings();
            $userSettings->setUser($this->getReference('user_propertywindow_admin_'. $i));
            $userSettings->setLanguage('en');
            $manager->persist($userSettings);
        }

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_propertywindow_agent_1'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        // Annan Users

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_agent_1'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_agent_2'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        for ($i = 1; $i <= 6; $i++) {
            $userSettings = new UserSettings();
            $userSettings->setUser($this->getReference('user_annan_colleague_'. $i));
            $userSettings->setLanguage('en');
            $manager->persist($userSettings);
        }

        // Oliver Users

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_oliver_agent_1'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        // Deans Users

        for ($i = 1; $i <= 3; $i++) {
            $userSettings = new UserSettings();
            $userSettings->setUser($this->getReference('user_deans_agent_'. $i));
            $userSettings->setLanguage('en');
            $manager->persist($userSettings);
        }


        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 18;
    }
}
