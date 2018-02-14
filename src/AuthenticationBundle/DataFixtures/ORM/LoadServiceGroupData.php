<?php
declare(strict_types = 1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\ServiceGroup;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceGroupData
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
        $serviceGroup->setIcon('flaticon-dashboard');
        $serviceGroup->setUrl('/dashboard');
        $this->setReference('service_group_dashboard', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Properties');
        $serviceGroup->setNl('Woningen');
        $serviceGroup->setIcon('flaticon-house');
        $serviceGroup->setUrl('/properties');
        $this->setReference('service_group_properties', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Users');
        $serviceGroup->setNl('Gebruikers');
        $serviceGroup->setIcon('flaticon-users');
        $this->setReference('service_group_users', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Agents');
        $serviceGroup->setNl('Makelaars');
        $serviceGroup->setIcon('flaticon-internet');
        $serviceGroup->setUrl('/agents');
        $this->setReference('service_group_agents', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Services');
        $serviceGroup->setNl('Diensten');
        $serviceGroup->setIcon('flaticon-app');
        $serviceGroup->setUrl('/services');
        $this->setReference('service_group_services_manager', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Appointments');
        $serviceGroup->setNl('Afspraken');
        $serviceGroup->setIcon('flaticon-calendar');
        $serviceGroup->setUrl('/appointments');
        $this->setReference('service_group_appointments', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Viewings');
        $serviceGroup->setNl('Bezichtigingen');
        $serviceGroup->setIcon('flaticon-house-1');
        $serviceGroup->setUrl('/viewings');
        $this->setReference('service_group_viewings', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Interest');
        $serviceGroup->setNl('Interesse');
        $serviceGroup->setIcon('flaticon-house-9');
        $serviceGroup->setUrl('/interest');
        $this->setReference('service_group_interest', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Offers');
        $serviceGroup->setNl('Biedingen');
        $serviceGroup->setIcon('flaticon-house-16');
        $serviceGroup->setUrl('/offers');
        $this->setReference('service_group_offers', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Surveys');
        $serviceGroup->setNl('Surveys');
        $serviceGroup->setIcon('flaticon-blueprint');
        $serviceGroup->setUrl('/surverys');
        $this->setReference('service_group_surveys', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Contacts');
        $serviceGroup->setNl('Contacten');
        $serviceGroup->setIcon('flaticon-users');
        $this->setReference('service_group_contacts', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Property Alerts');
        $serviceGroup->setNl('Property Notificaties');
        $serviceGroup->setIcon('flaticon-megaphone-1');
        $serviceGroup->setUrl('/email-alerts');
        $this->setReference('service_group_property_alerts', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Email');
        $serviceGroup->setNl('Email');
        $serviceGroup->setIcon('flaticon-envelope-1');
        $serviceGroup->setUrl('/email');
        $this->setReference('service_group_email', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Notifications');
        $serviceGroup->setNl('Notificaties');
        $serviceGroup->setIcon('flaticon-music-1');
        $serviceGroup->setUrl('/notifications');
        $this->setReference('service_group_notifications', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Invoices');
        $serviceGroup->setNl('Invoices');
        $serviceGroup->setIcon('flaticon-file');
        $this->setReference('service_group_invoices', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Statistics');
        $serviceGroup->setNl('Statistieken');
        $serviceGroup->setIcon('flaticon-graph-2');
        $this->setReference('service_group_statistics', $serviceGroup);
        $manager->persist($serviceGroup);

        $serviceGroup = new ServiceGroup();
        $serviceGroup->setEn('Settings');
        $serviceGroup->setNl('Instellingen');
        $serviceGroup->setIcon('flaticon-settings');
        $this->setReference('service_group_settings', $serviceGroup);
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
