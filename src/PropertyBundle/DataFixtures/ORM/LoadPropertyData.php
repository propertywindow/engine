<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\Property;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadPropertyData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadPropertyData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Annan Properties

        $property = new Property();
        $property->setKind($this->getReference('kind_sale'));
        $property->setAgent($this->getReference('agent_6'));
        $property->setClient($this->getReference('client_annan_1'));
        $property->setTerms($this->getReference('term_offers_over'));
        $property->setSubType($this->getReference('sub_type_end_terraced_house'));
        $property->setOnline(true);
        $property->setStreet('Dalkeith Street');
        $property->setHouseNumber('3');
        $property->setPostcode('EH15 2HP');
        $property->setCity('Edinburgh');
        $property->setCountry('GB');
        $property->setPrice(725000);
        $property->setLat(55.948368);
        $property->setLng(-3.101990);
        $property->setEspc(false);
        $property->setArchived(false);
        $this->addReference('property_annan_1', $property);
        $manager->persist($property);

        $property = new Property();
        $property->setKind($this->getReference('kind_sale'));
        $property->setAgent($this->getReference('agent_6'));
        $property->setClient($this->getReference('client_annan_2'));
        $property->setTerms($this->getReference('term_fixed_price'));
        $property->setSubType($this->getReference('sub_type_end_terraced_house'));
        $property->setOnline(true);
        $property->setStreet('Brunstane Road North');
        $property->setHouseNumber('7A');
        $property->setPostcode('EH15 2DL');
        $property->setCity('Edinburgh');
        $property->setCountry('GB');
        $property->setPrice(600000);
        $property->setLat(55.950950);
        $property->setLng(-3.102555);
        $property->setEspc(false);
        $property->setArchived(false);
        $this->addReference('property_annan_2', $property);
        $manager->persist($property);

        $property = new Property();
        $property->setKind($this->getReference('kind_sale'));
        $property->setAgent($this->getReference('agent_6'));
        $property->setClient($this->getReference('client_annan_3'));
        $property->setTerms($this->getReference('term_offers_over'));
        $property->setSubType($this->getReference('sub_type_detached_house'));
        $property->setOnline(true);
        $property->setStreet('St Marks Place');
        $property->setHouseNumber('3');
        $property->setPostcode('EH15 2PY');
        $property->setCity('Edinburgh');
        $property->setCountry('GB');
        $property->setPrice(575000);
        $property->setLat(55.950046);
        $property->setLng(-3.108808);
        $property->setEspc(false);
        $property->setArchived(false);
        $this->addReference('property_annan_3', $property);
        $manager->persist($property);





        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 30;
    }
}
