<?php
declare(strict_types = 1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\ServiceGroupTemplate;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceGroupTemplateData
 */
class LoadServiceGroupTemplateData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Admin

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_users'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_agents'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_services_manager'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_email'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_notifications'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_invoices'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_statistics'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_settings'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceGroupTemplate);

        // Agent

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_users'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_services_manager'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_email'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_notifications'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_statistics'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_settings'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceGroupTemplate);

        // Colleague

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_properties'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_appointments'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_viewings'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_interest'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_offers'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_surveys'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_contacts'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_property_alerts'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_email'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_notifications'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_statistics'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_settings'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceGroupTemplate);

        // Client

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_properties'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_client'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_appointments'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_client'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_viewings'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_client'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_interest'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_client'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_offers'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_client'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_surveys'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_client'));
        $manager->persist($serviceGroupTemplate);

        $serviceGroupTemplate = new ServiceGroupTemplate();
        $serviceGroupTemplate->setServiceGroup($this->getReference('service_group_statistics'));
        $serviceGroupTemplate->setUserType($this->getReference('user_type_client'));
        $manager->persist($serviceGroupTemplate);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 22;
    }
}
