<?php
declare(strict_types = 1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\ServiceTemplate;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceTemplateData
 */
class LoadServiceTemplateData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_types'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_blacklist'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_users'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_impersonate'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_chat'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_activities'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_block_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_agent'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_agent'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_agent'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_agent'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);


        // Agent

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_archive_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_users'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_impersonate'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_chat'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_activities'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_block_user'));
        $serviceTemplate->setUserType($this->getReference('user_type_agent'));
        $manager->persist($serviceTemplate);


        // Colleague


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_archive_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_appointment'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_appointment'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_appointment'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_appointment'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_viewing'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_viewing'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_viewing'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_viewing'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_interest'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_interest'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_interest'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_interest'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_offer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_offer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_offer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_offer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_surveys'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_surveys'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_surveys'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_surveys'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_agencies'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_agency'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_agency'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_agency'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_agency'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_solicitors'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_solicitor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_solicitor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_solicitor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_solicitor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_surveyors'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_surveyor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_surveyor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_surveyor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_surveyor'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_clients'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_client'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_client'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_client'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_client'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_buyers'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_buyer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_buyer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_buyer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_buyer'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_colleagues'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_colleague'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_colleague'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_colleague'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_colleague'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_applicant'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_applicant'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_applicant'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_applicant'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_email'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_email'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_email'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_email'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_notification'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_notification'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_notification'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_notification'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_invoices'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_products'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_invoice'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_payment'));
        $serviceTemplate->setUserType($this->getReference('user_type_colleague'));
        $manager->persist($serviceTemplate);


        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 23;
    }
}
