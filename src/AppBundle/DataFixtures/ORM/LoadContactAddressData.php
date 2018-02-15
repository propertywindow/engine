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

        $address = new ContactAddress();
        $address->setStreet('Cadzow PlaceLondon road');
        $address->setHouseNumber('19');
        $address->setPostcode('EH7 5SN');
        $address->setCity('Edinburgh');
        $address->setCountry('GB');
        $this->setReference('address_agent_annan_agency_1', $address);
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
