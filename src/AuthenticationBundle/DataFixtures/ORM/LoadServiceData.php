<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\Service;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadServiceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Properties

        $service = new Service();
        $service->setFunctionName('getProperty');
        $service->setEn('View Property');
        $service->setNl('Bekijk Woning');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $this->addReference('service_view_property', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setFunctionName('createProperty');
        $service->setEn('Add Property');
        $service->setNl('Woning Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setUrl('/properties/add');
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $this->addReference('service_add_property', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setFunctionName('updateProperty');
        $service->setEn('Edit Property');
        $service->setNl('Bewerk Woning');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setUrl('/properties/edit/');
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $this->addReference('service_edit_property', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setFunctionName('deleteProperty');
        $service->setEn('Delete Property');
        $service->setNl('Verwijder Woning');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setUrl('/properties/delete/');
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $this->addReference('service_delete_property', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setFunctionName('archiveProperty');
        $service->setEn('Archive Property');
        $service->setNl('Archiveer Woning');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setUrl('/properties/archive/');
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $this->addReference('service_archive_property', $service);
        $manager->persist($service);

        // Users

        $service = new Service();
        $service->setEn('Types');
        $service->setNl('Types');
        $service->setIcon('zmdi zmdi-label');
        $service->setUrl('/users/types');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_types', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Blacklist');
        $service->setNl('Blacklist');
        $service->setIcon('zmdi zmdi-lock');
        $service->setUrl('/users/blacklist');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_blacklist', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Users');
        $service->setNl('Gebruikers');
        $service->setIcon('zmdi zmdi-accounts-list');
        $service->setUrl('/users/users');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_users', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Impersonate');
        $service->setNl('Impersoneer');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_impersonate', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Chat');
        $service->setNl('Chat');
        $service->setIcon('zmdi zmdi-comment-more');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_chat', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Activities');
        $service->setNl('Activiteiten');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_activities', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View User');
        $service->setNl('Bekijk Gebruiker');
        $service->setIcon('zmdi zmdi-accounts');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_view_user', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add User');
        $service->setNl('Gebruiker Toevoegen');
        $service->setIcon('zmdi zmdi-account-add');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_add_user', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit User');
        $service->setNl('Bewerk Gebruiker');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_edit_user', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete User');
        $service->setNl('Verwijder Gebruiker');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_delete_user', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Block User');
        $service->setNl('Blokkeer Gebruiker');
        $service->setIcon('zmdi zmdi-block');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $this->addReference('service_block_user', $service);
        $manager->persist($service);

        // Agents

        $service = new Service();
        $service->setEn('View Agent');
        $service->setNl('Bekijk Agent');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $this->addReference('service_view_agent', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Agent');
        $service->setNl('Agent Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $this->addReference('service_add_agent', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Agent');
        $service->setNl('Bewerk Agent');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $this->addReference('service_edit_agent', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Agent');
        $service->setNl('Verwijder Agent');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $this->addReference('service_delete_agent', $service);
        $manager->persist($service);

        // Appointments

        $service = new Service();
        $service->setEn('View Appointment');
        $service->setNl('Bekijk Afspraak');
        $service->setIcon('zmdi zmdi-calendar');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $this->addReference('service_view_appointment', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Appointment');
        $service->setNl('Afspraak Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $this->addReference('service_add_appointment', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Appointment');
        $service->setNl('Bewerk Afspraak');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $this->addReference('service_edit_appointment', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Appointment');
        $service->setNl('Verwijder Afspraak');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $this->addReference('service_delete_appointment', $service);
        $manager->persist($service);

        // Viewings

        $service = new Service();
        $service->setEn('View Viewing');
        $service->setNl('Bekijk Bezichtiging');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $this->addReference('service_view_viewing', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Viewing');
        $service->setNl('Bezichtiging Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $this->addReference('service_add_viewing', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Viewing');
        $service->setNl('Bewerk Bezichtiging');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $this->addReference('service_edit_viewing', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Viewing');
        $service->setNl('Verwijder Bezichtiging');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $this->addReference('service_delete_viewing', $service);
        $manager->persist($service);

        // Interest

        $service = new Service();
        $service->setEn('View Interest');
        $service->setNl('Bekijk Interesse');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $this->addReference('service_view_interest', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Interest');
        $service->setNl('Interesse toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $this->addReference('service_add_interest', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Interest');
        $service->setNl('Bewerk Interesse');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $this->addReference('service_edit_interest', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Interest');
        $service->setNl('Verwijder Interesse');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $this->addReference('service_delete_interest', $service);
        $manager->persist($service);

        // Offers

        $service = new Service();
        $service->setEn('View Offer');
        $service->setNl('Bekijk Bod');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $this->addReference('service_view_offer', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Offer');
        $service->setNl('Bod toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $this->addReference('service_add_offer', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Offer');
        $service->setNl('Bewerk Bod');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $this->addReference('service_edit_offer', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Offer');
        $service->setNl('Verwijder Bod');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $this->addReference('service_delete_offer', $service);
        $manager->persist($service);

        // Surveys

        $service = new Service();
        $service->setEn('View Survey');
        $service->setNl('Bekijk Enquête');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $this->addReference('service_view_surveys', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Survey');
        $service->setNl('Enquête toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $this->addReference('service_add_surveys', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Survey');
        $service->setNl('Bewerk Enquête');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $this->addReference('service_edit_surveys', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Survey');
        $service->setNl('Verwijder Enquête');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $this->addReference('service_delete_surveys', $service);
        $manager->persist($service);

        // Contacts

        $service = new Service();
        $service->setEn('Agencies');
        $service->setNl('Agentschappen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/contacts/agencies');
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_agencies', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Agency');
        $service->setNl('Bekijk Agentschap');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_view_agency', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Agency');
        $service->setNl('Agentschap toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_add_agency', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Agency');
        $service->setNl('Bewerk Agentschap');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_edit_agency', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Agency');
        $service->setNl('Verwijder Agentschap');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_delete_agency', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Solicitors');
        $service->setNl('Solicitors');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/contacts/solicitors');
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_solicitors', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Solicitor');
        $service->setNl('Bekijk Solicitor');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_view_solicitor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Solicitor');
        $service->setNl('Solicitor toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_add_solicitor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Solicitor');
        $service->setNl('Bewerk Solicitor');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_edit_solicitor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Solicitor');
        $service->setNl('Verwijder Solicitor');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_delete_solicitor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Surveyors');
        $service->setNl('Surveyors');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/contacts/surveyors');
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_surveyors', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Surveyor');
        $service->setNl('Bekijk Surveyor');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_view_surveyor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Surveyor');
        $service->setNl('Surveyor toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_add_surveyor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Surveyor');
        $service->setNl('Bewerk Surveyor');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_edit_surveyor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Surveyor');
        $service->setNl('Verwijder Surveyor');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_delete_surveyor', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Clients');
        $service->setNl('Klanten');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/contacts/clients');
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_clients', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Client');
        $service->setNl('Bekijk Klant');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_view_client', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Client');
        $service->setNl('Klant toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_add_client', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Client');
        $service->setNl('Bewerk Klant');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_edit_client', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Client');
        $service->setNl('Verwijder Klant');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_delete_client', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Buyers');
        $service->setNl('Kopers');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/contacts/buyers');
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_buyers', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Buyer');
        $service->setNl('Bekijk Koper');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_view_buyer', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Buyer');
        $service->setNl('Koper toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_add_buyer', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Buyer');
        $service->setNl('Bewerk Koper');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_edit_buyer', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Buyer');
        $service->setNl('Verwijder Koper');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_delete_buyer', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Colleagues');
        $service->setNl('Collega\'s');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/contacts/colleagues');
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_colleagues', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Colleague');
        $service->setNl('Bekijk Collega');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_view_colleague', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Colleague');
        $service->setNl('Collega toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_add_colleague', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Colleague');
        $service->setNl('Bewerk Collega');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_edit_colleague', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Colleague');
        $service->setNl('Verwijder Collega');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $this->addReference('service_delete_colleague', $service);
        $manager->persist($service);

        // Email Alerts

        $service = new Service();
        $service->setEn('View Applicant');
        $service->setNl('Bekijk Aanvrager');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $this->addReference('service_view_applicant', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Applicant');
        $service->setNl('Aanvrager toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $this->addReference('service_add_applicant', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Applicant');
        $service->setNl('Bewerk Aanvrager');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $this->addReference('service_edit_applicant', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Applicant');
        $service->setNl('Verwijder Aanvrager');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $this->addReference('service_delete_applicant', $service);
        $manager->persist($service);

        // Inbox

        $service = new Service();
        $service->setEn('View Email');
        $service->setNl('Bekijk Email');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $this->addReference('service_view_email', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Email');
        $service->setNl('Email toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $this->addReference('service_add_email', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Email');
        $service->setNl('Bewerk Email');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $this->addReference('service_edit_email', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Email');
        $service->setNl('Verwijder Email');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $this->addReference('service_delete_email', $service);
        $manager->persist($service);

        // Notifications

        $service = new Service();
        $service->setEn('View Notification');
        $service->setNl('Bekijk Notificatie');
        $service->setIcon('zmdi zmdi-notifications');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $this->addReference('service_view_notification', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Notification');
        $service->setNl('Notificatie Toevoegen');
        $service->setIcon('zmdi zmdi-notifications-add');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $this->addReference('service_add_notification', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Notification');
        $service->setNl('Bewerk Notificatie');
        $service->setIcon('zmdi zmdi-notifications-none');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $this->addReference('service_edit_notification', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Notification');
        $service->setNl('Verwijder Notificatie');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $this->addReference('service_delete_notification', $service);
        $manager->persist($service);

        // Invoices

        $service = new Service();
        $service->setEn('Invoices');
        $service->setNl('Facturen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/invoices/invoices');
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $this->addReference('service_invoices', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Products');
        $service->setNl('Producten');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/invoices/products');
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $this->addReference('service_products', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Invoice');
        $service->setNl('Maak Factuur');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $this->addReference('service_add_invoice', $service);
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Payment');
        $service->setNl('Betaling Toevoegen');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $this->addReference('service_add_payment', $service);
        $manager->persist($service);

        // Statistics

        $service = new Service();
        $service->setEn('Server');
        $service->setNl('Server');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/server');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Agents');
        $service->setNl('Agents');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/agents');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Properties');
        $service->setNl('Woningen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/properties');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Offers');
        $service->setNl('Biedingen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/offers');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Appointments');
        $service->setNl('Afspraken');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/appointments');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Viewings');
        $service->setNl('Bezichtigingen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/viewings');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Interests');
        $service->setNl('Interesse');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/interests');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Surveys');
        $service->setNl('Enquêtes');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/surveys');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Error Log');
        $service->setNl('Fout meldingen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/errors');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Logins');
        $service->setNl('Logins');
        $service->setIcon('zmdi zmdi-lock-open');
        $service->setVisible(true);
        $service->setUrl('/statistics/logins');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Email Alerts');
        $service->setNl('Email Notificaties');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/statistics/email-alerts');
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        // Settings

        $service = new Service();
        $service->setEn('Templates');
        $service->setNl('Templates');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/settings/templates');
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Agent Details');
        $service->setNl('Agent Details');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/settings/agent-details');
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Interface');
        $service->setNl('Interface');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/settings/interface');
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Mailbox');
        $service->setNl('Mailbox');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setUrl('/settings/mailbox');
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);


        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 21;
    }
}
