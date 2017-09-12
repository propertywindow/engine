<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\ServiceGroup;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceGroupData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadServiceGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Dashboard');
        $serviceGroup->setNl('Dashboard');
        $serviceGroup->setIcon('zmdi zmdi-palette');
        $serviceGroup->setUrl('/dashboard');
        $this->addReference('service_group_dashboard', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Properties');
        $serviceGroup->setNl('Woningen');
        $serviceGroup->setIcon('zmdi zmdi zmdi-city-alt');
        $serviceGroup->setUrl('/properties');
        $this->addReference('service_group_properties', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Users');
        $serviceGroup->setNl('Gebruikers');
        $serviceGroup->setIcon('zmdi zmdi-accounts');
        $this->addReference('service_group_users', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Agents');
        $serviceGroup->setNl('Makelaars');
        $serviceGroup->setIcon('zmdi zmdi-store');
        $serviceGroup->setUrl('/agents');
        $this->addReference('service_group_agents', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Services Manager');
        $serviceGroup->setNl('Diensten Beheren');
        $serviceGroup->setIcon('zmdi zmdi-ungroup');
        $serviceGroup->setUrl('/services');
        $this->addReference('service_group_services_manager', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Appointments');
        $serviceGroup->setNl('Afspraken');
        $serviceGroup->setIcon('zmdi zmdi-calendar');
        $serviceGroup->setUrl('/appointments');
        $this->addReference('service_group_appointments', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Viewings');
        $serviceGroup->setNl('Bezichtigingen');
        $serviceGroup->setIcon('zmdi zmdi-eye');
        $serviceGroup->setUrl('/viewings');
        $this->addReference('service_group_viewings', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Interest');
        $serviceGroup->setNl('Interesse');
        $serviceGroup->setIcon('mdi mdi-lightbulb');
        $serviceGroup->setUrl('/interest');
        $this->addReference('service_group_interest', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Offers');
        $serviceGroup->setNl('Biedingen');
        $serviceGroup->setIcon('zmdi zmdi-money');
        $serviceGroup->setUrl('/offers');
        $this->addReference('service_group_offers', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Surveys');
        $serviceGroup->setNl('Surveys');
        $serviceGroup->setIcon('zmdi zmdi-home');
        $serviceGroup->setUrl('/surverys');
        $this->addReference('service_group_surveys', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Contacts');
        $serviceGroup->setNl('Contacten');
        $serviceGroup->setIcon('zmdi zmdi-accounts-list');
        $this->addReference('service_group_contacts', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Email Alerts');
        $serviceGroup->setNl('Email Notificaties');
        $serviceGroup->setIcon('zmdi zmdi-alarm');
        $serviceGroup->setUrl('/email-alerts');
        $this->addReference('service_group_email_alerts', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Inbox');
        $serviceGroup->setNl('Inbox');
        $serviceGroup->setIcon('zmdi zmdi-email');
        $serviceGroup->setUrl('/inbox');
        $this->addReference('service_group_inbox', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Notifications');
        $serviceGroup->setNl('Notificaties');
        $serviceGroup->setIcon('zmdi zmdi-notifications');
        $serviceGroup->setUrl('/notifications');
        $this->addReference('service_group_notifications', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Invoices');
        $serviceGroup->setNl('Invoices');
        $serviceGroup->setIcon('zmdi zmdi-file-text');
        $this->addReference('service_group_invoices', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Statistics');
        $serviceGroup->setNl('Statistieken');
        $serviceGroup->setIcon('zmdi zmdi-chart');
        $this->addReference('service_group_statistics', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Settings');
        $serviceGroup->setNl('Instellingen');
        $serviceGroup->setIcon('zmdi zmdi-settings');
        $this->addReference('service_group_settings', $serviceGroup);
        $manager->persist($serviceGroup);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 20;
    }
}
