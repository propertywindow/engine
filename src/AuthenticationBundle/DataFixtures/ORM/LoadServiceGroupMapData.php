<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\ServiceGroupMap;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceGroupData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadServiceGroupMapData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Property Window Admins

        for ($i = 1; $i <= 2; $i++) {
            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_dashboard'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_users'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_agents'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_services_manager'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_inbox'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_notifications'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_invoices'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_statistics'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_propertywindow_admin_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_settings'));
            $manager->persist($serviceGroupMap);
        }


        // Annan Agent

        $serviceGroupMap = new ServiceGroupMap();
        $serviceGroupMap->setUser($this->getReference('user_annan_agent_1'));
        $serviceGroupMap->setServiceGroup($this->getReference('service_group_dashboard'));
        $manager->persist($serviceGroupMap);

        $serviceGroupMap = new ServiceGroupMap();
        $serviceGroupMap->setUser($this->getReference('user_annan_agent_1'));
        $serviceGroupMap->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($serviceGroupMap);

        $serviceGroupMap = new ServiceGroupMap();
        $serviceGroupMap->setUser($this->getReference('user_annan_agent_1'));
        $serviceGroupMap->setServiceGroup($this->getReference('service_group_notifications'));
        $manager->persist($serviceGroupMap);

        $serviceGroupMap = new ServiceGroupMap();
        $serviceGroupMap->setUser($this->getReference('user_annan_agent_1'));
        $serviceGroupMap->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($serviceGroupMap);

        $serviceGroupMap = new ServiceGroupMap();
        $serviceGroupMap->setUser($this->getReference('user_annan_agent_1'));
        $serviceGroupMap->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($serviceGroupMap);

        // Annan Colleagues

        for ($i = 1; $i <= 6; $i++) {
            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_dashboard'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_properties'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_appointments'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_viewings'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_interest'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_offers'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_surveys'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_contacts'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_email_alerts'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_inbox'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_notifications'));
            $manager->persist($serviceGroupMap);

            $serviceGroupMap = new ServiceGroupMap();
            $serviceGroupMap->setUser($this->getReference('user_annan_colleague_' . $i));
            $serviceGroupMap->setServiceGroup($this->getReference('service_group_statistics'));
            $manager->persist($serviceGroupMap);
        }



        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 24;
    }
}
