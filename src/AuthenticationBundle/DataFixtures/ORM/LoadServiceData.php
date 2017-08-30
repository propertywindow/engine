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
        $service = new Service();
        $service->setEn('View Property');
        $service->setNl('Bekijk Woning');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Property');
        $service->setNl('Woning Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Property');
        $service->setNl('Bewerk Woning');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Property');
        $service->setNl('Verwijder Woning');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Archive Property');
        $service->setNl('Archiveer Woning');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('Types');
        $service->setNl('Types');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Blacklist');
        $service->setNl('Blacklist');
        $service->setIcon('zmdi zmdi-lock');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Users');
        $service->setNl('Gebruikers');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Impersonate');
        $service->setNl('Impersoneer');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Chat');
        $service->setNl('Chat');
        $service->setIcon('zmdi zmdi-comment-more');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Activities');
        $service->setNl('Activiteiten');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Users');
        $service->setNl('Bekijk Gebruikers');
        $service->setIcon('zmdi zmdi-accounts');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add User');
        $service->setNl('Gebruiker Toevoegen');
        $service->setIcon('zmdi zmdi-account-add');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit User');
        $service->setNl('Bewerk Gebruiker');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete User');
        $service->setNl('Verwijder Gebruiker');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Block User');
        $service->setNl('Blokkeer Gebruiker');
        $service->setIcon('zmdi zmdi-block');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_users'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Agent');
        $service->setNl('Bekijk Agent');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Create Agent');
        $service->setNl('Agent Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Agent');
        $service->setNl('Bewerk Agent');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Agent');
        $service->setNl('Verwijder Agent');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_agents'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Appointment');
        $service->setNl('Bekijk Afspraak');
        $service->setIcon('zmdi zmdi-calendar');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Appointment');
        $service->setNl('Afspraak Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Appointment');
        $service->setNl('Bewerk Afspraak');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Appointment');
        $service->setNl('Verwijder Afspraak');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_appointments'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Viewing');
        $service->setNl('Bekijk Bezichtiging');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Viewing');
        $service->setNl('Bezichtiging Toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Viewing');
        $service->setNl('Bewerk Bezichtiging');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Viewing');
        $service->setNl('Verwijder Bezichtiging');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_viewings'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Interest');
        $service->setNl('Bekijk Interesse');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Interest');
        $service->setNl('Interesse toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Interest');
        $service->setNl('Bewerk Interesse');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Interest');
        $service->setNl('Verwijder Interesse');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_interest'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Offer');
        $service->setNl('Bekijk Bod');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Offer');
        $service->setNl('Bod toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Offer');
        $service->setNl('Bewerk Bod');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Offer');
        $service->setNl('Verwijder Bod');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_offers'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Survey');
        $service->setNl('Bekijk Enquête');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Survey');
        $service->setNl('Enquête toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Survey');
        $service->setNl('Bewerk Enquête');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Survey');
        $service->setNl('Verwijder Enquête');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('Agencies');
        $service->setNl('Agentschappen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Agency');
        $service->setNl('Bekijk Agentschap');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Agency');
        $service->setNl('Agentschap toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Agency');
        $service->setNl('Bewerk Agentschap');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Agency');
        $service->setNl('Verwijder Agentschap');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Solicitors');
        $service->setNl('Solicitors');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Solicitor');
        $service->setNl('Bekijk Solicitor');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Solicitor');
        $service->setNl('Solicitor toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Solicitor');
        $service->setNl('Bewerk Solicitor');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Solicitor');
        $service->setNl('Verwijder Solicitor');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Surveyors');
        $service->setNl('Surveyors');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Surveyor');
        $service->setNl('Bekijk Surveyor');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Surveyor');
        $service->setNl('Surveyor toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Surveyor');
        $service->setNl('Bewerk Surveyor');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Surveyor');
        $service->setNl('Verwijder Surveyor');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Clients');
        $service->setNl('Klanten');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Client');
        $service->setNl('Bekijk Klant');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Client');
        $service->setNl('Klant toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Client');
        $service->setNl('Bewerk Klant');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Client');
        $service->setNl('Verwijder Klant');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Buyers');
        $service->setNl('Kopers');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Buyer');
        $service->setNl('Bekijk Koper');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Buyer');
        $service->setNl('Koper toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Buyer');
        $service->setNl('Bewerk Koper');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Buyer');
        $service->setNl('Verwijder Koper');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Colleagues');
        $service->setNl('Collega\'s');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_contacts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('View Client');
        $service->setNl('Bekijk Klant');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Client');
        $service->setNl('Klant toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Client');
        $service->setNl('Bewerk Klant');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Client');
        $service->setNl('Verwijder Klant');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_surveys'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Applicant');
        $service->setNl('Bekijk Aanvrager');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Applicant');
        $service->setNl('Aanvrager toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Applicant');
        $service->setNl('Bewerk Aanvrager');
        $service->setIcon('zmdi zmdi-edit');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Applicant');
        $service->setNl('Verwijder Aanvrager');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_email_alerts'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Email');
        $service->setNl('Bekijk Email');
        $service->setIcon('zmdi zmdi-search');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Email');
        $service->setNl('Email toevoegen');
        $service->setIcon('zmdi zmdi-plus');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Email');
        $service->setNl('Bewerk Email');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Email');
        $service->setNl('Verwijder Email');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_inbox'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('View Notification');
        $service->setNl('Bekijk Notificatie');
        $service->setIcon('zmdi zmdi-notifications');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Notification');
        $service->setNl('Notificatie Toevoegen');
        $service->setIcon('zmdi zmdi-notifications-add');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Notification');
        $service->setNl('Bewerk Notificatie');
        $service->setIcon('zmdi zmdi-notifications-none');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Notification');
        $service->setNl('Verwijder Notificatie');
        $service->setIcon('zmdi zmdi-delete');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_notifications'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('Invoices');
        $service->setNl('Facturen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Products');
        $service->setNl('Producten');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Create Invoice');
        $service->setNl('Maak Factuur');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Payment');
        $service->setNl('Betaling Toevoegen');
        $service->setIcon('');
        $service->setVisible(false);
        $service->setServiceGroup($this->getReference('service_group_invoices'));
        $manager->persist($service);


        $service = new Service();
        $service->setEn('Server');
        $service->setNl('Server');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Agents');
        $service->setNl('Agents');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Properties');
        $service->setNl('Woningen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Offers');
        $service->setNl('Biedingen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Appointments');
        $service->setNl('Afspraken');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Viewings');
        $service->setNl('Bezichtigingen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Interests');
        $service->setNl('Interesse');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Surveys');
        $service->setNl('Enquêtes');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Error Log');
        $service->setNl('Fout meldingen');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Logins');
        $service->setNl('Logins');
        $service->setIcon('zmdi zmdi-lock-open');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Email Alerts');
        $service->setNl('Email Notificaties');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_statistics'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Templates');
        $service->setNl('Templates');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Agent Details');
        $service->setNl('Agent Details');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Interface');
        $service->setNl('Interface');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Mailbox');
        $service->setNl('Mailbox');
        $service->setIcon('');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_settings'));
        $manager->persist($service);


        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 11;
    }
}
