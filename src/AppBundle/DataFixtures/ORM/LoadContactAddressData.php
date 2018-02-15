<?php
declare(strict_types = 1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ContactAddress;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadContactAddress Data
 */
class LoadContactAddressData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Agent

        $address = new ContactAddress();
        $address->setStreet('Portobello High Street');
        $address->setHouseNumber('27');
        $address->setPostcode('EH15 1DE');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_propertywindow_1', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Portobello High Street');
        $address->setHouseNumber('229');
        $address->setPostcode('EH15 2AN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_annan_1', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('High Street');
        $address->setHouseNumber('84');
        $address->setPostcode('EH21 7BX');
        $address->setCity('Musselburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_annan_2', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('High Street');
        $address->setHouseNumber('13');
        $address->setPostcode('TD9 9DH');
        $address->setCity('Hawick');
        $address->setCountry('GB');
        $this->setReference('address_agent_oliver_1', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('St Patrick Street');
        $address->setHouseNumber('3');
        $address->setPostcode('EH8 9ES');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_deans_1', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('St Johns Road');
        $address->setHouseNumber('135-137');
        $address->setPostcode('EH12 7SB');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_deans_2', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('High Street');
        $address->setHouseNumber('31A');
        $address->setPostcode('EH30 9PP');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_deans_3', $address);
        $manager->persist($address);

        // Agency

        $address = new ContactAddress();
        $address->setStreet('Cadzow PlaceLondon road');
        $address->setHouseNumber('19');
        $address->setPostcode('EH7 5SN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_annan_agency_1', $address);
        $manager->persist($address);

        // Solicitor

        $address = new ContactAddress();
        $address->setStreet('Cadzow PlaceLondon road');
        $address->setHouseNumber('19');
        $address->setPostcode('EH7 5SN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_annan_solicitor_1', $address);
        $manager->persist($address);

        // Users

        $address = new ContactAddress();
        $address->setStreet('Graafsedijk');
        $address->setHouseNumber('19');
        $address->setPostcode('5437 NG');
        $address->setCity('Beers');
        $address->setCountry('NL');
        $this->setReference('address_user_propertywindow_admin_1', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Portobello High Street');
        $address->setHouseNumber('27');
        $address->setPostcode('EH15 1DE');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_user_propertywindow_admin_2', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Portobello High Street');
        $address->setHouseNumber('229');
        $address->setPostcode('EH15 2AN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_colleague_1', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Portobello High Street');
        $address->setHouseNumber('229');
        $address->setPostcode('EH15 2AN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_colleague_2', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Portobello High Street');
        $address->setHouseNumber('229');
        $address->setPostcode('EH15 2AN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_colleague_3', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Portobello High Street');
        $address->setHouseNumber('229');
        $address->setPostcode('EH15 2AN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_colleague_4', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('High Street');
        $address->setHouseNumber('84');
        $address->setPostcode('EH21 7BX');
        $address->setCity('Musselburgh');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_colleague_5', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('High Street');
        $address->setHouseNumber('84');
        $address->setPostcode('EH21 7BX');
        $address->setCity('Musselburgh');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_colleague_6', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Highfield Road');
        $address->setHouseNumber('9124');
        $address->setPostcode('EC6 5JQ');
        $address->setCity('Stoke-on-trent');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_1', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Chester Road');
        $address->setHouseNumber('2168');
        $address->setPostcode('TE8Z 3DN');
        $address->setCity('Bath');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_2', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('York Road');
        $address->setHouseNumber('9530');
        $address->setPostcode('BF3A 6NF');
        $address->setCity('Manchester');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_3', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Queensway');
        $address->setHouseNumber('8154');
        $address->setPostcode('R25 1JH');
        $address->setCity('Newcastle Upon Tyne');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_4', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('York Road');
        $address->setHouseNumber('3595');
        $address->setPostcode('D1M 6GZ');
        $address->setCity('Preston');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_5', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('South Street');
        $address->setHouseNumber('7600');
        $address->setPostcode('T04 5UU');
        $address->setCity('Wolverhampton');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_6', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Main Street');
        $address->setHouseNumber('7417');
        $address->setPostcode('ZU31 2SE');
        $address->setCity('Winchester');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_7', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('The Grove');
        $address->setHouseNumber('6925');
        $address->setPostcode('T04 5UU');
        $address->setCity('Glasgow');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_8', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('School Lane');
        $address->setHouseNumber('8165');
        $address->setPostcode('HG0 2GG');
        $address->setCity('Norwich');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_9', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Chester Road');
        $address->setHouseNumber('3336');
        $address->setPostcode('X0I 4HX');
        $address->setCity('St Albans');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_10', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Grove Road');
        $address->setHouseNumber('5394');
        $address->setPostcode('IZ0 8FY');
        $address->setCity('Norwich');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_11', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Queensway');
        $address->setHouseNumber('7129');
        $address->setPostcode('Y1T 7GZ');
        $address->setCity('Hereford');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_12', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Station Road');
        $address->setHouseNumber('7140');
        $address->setPostcode('UD45 7US');
        $address->setCity('City Of London');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_13', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('The Green');
        $address->setHouseNumber('7818');
        $address->setPostcode('F5J 8AZ');
        $address->setCity('Canterbury');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_14', $address);
        $manager->persist($address);

        $address = new ContactAddress();
        $address->setStreet('Chester Road');
        $address->setHouseNumber('7993');
        $address->setPostcode('HH37 8YQ');
        $address->setCity('Carlisle');
        $address->setCountry('GB');
        $this->setReference('address_user_annan_client_15', $address);
        $manager->persist($address);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }
}
