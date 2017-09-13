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

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_propertywindow_admin_1'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_propertywindow_admin_2'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        // Annan

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_agent_1'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_colleague_1'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_colleague_2'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_colleague_3'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_colleague_4'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_colleague_5'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_annan_colleague_6'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);


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
