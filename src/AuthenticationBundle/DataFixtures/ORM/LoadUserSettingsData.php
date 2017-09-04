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
        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_admin_1'));
        $userSettings->setLanguage('nl');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_admin_2'));
        $userSettings->setLanguage('en');
        $manager->persist($userSettings);

        $userSettings = new UserSettings();
        $userSettings->setUser($this->getReference('user_client_1'));
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
