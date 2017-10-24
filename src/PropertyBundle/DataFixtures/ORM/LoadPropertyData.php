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

//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_1'));
//        $property->setTerms($this->getReference('term_offers_over'));
//        $property->setSubType($this->getReference('sub_type_end_terraced_house'));
//        $property->setOnline(true);
//        $property->setStreet('Dalkeith Street');
//        $property->setHouseNumber('3');
//        $property->setPostcode('EH15 2HP');
//        $property->setCity('Edinburgh');
//        $property->setCountry('GB');
//        $property->setPrice(725000);
//        $property->setLat(55.948368);
//        $property->setLng(-3.101990);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_1', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_2'));
//        $property->setTerms($this->getReference('term_fixed_price'));
//        $property->setSubType($this->getReference('sub_type_end_terraced_house'));
//        $property->setOnline(true);
//        $property->setStreet('Brunstane Road North');
//        $property->setHouseNumber('7A');
//        $property->setPostcode('EH15 2DL');
//        $property->setCity('Edinburgh');
//        $property->setCountry('GB');
//        $property->setPrice(600000);
//        $property->setLat(55.950950);
//        $property->setLng(-3.102555);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_2', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_3'));
//        $property->setTerms($this->getReference('term_offers_over'));
//        $property->setSubType($this->getReference('sub_type_detached_house'));
//        $property->setOnline(true);
//        $property->setStreet('St Marks Place');
//        $property->setHouseNumber('3');
//        $property->setPostcode('EH15 2PY');
//        $property->setCity('Edinburgh');
//        $property->setCountry('GB');
//        $property->setPrice(575000);
//        $property->setLat(55.950046);
//        $property->setLng(-3.108808);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_3', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_4'));
//        $property->setTerms($this->getReference('term_fixed_price'));
//        $property->setSubType($this->getReference('sub_type_second_floor_flat'));
//        $property->setOnline(true);
//        $property->setStreet('High Street');
//        $property->setHouseNumber('149B');
//        $property->setPostcode('EH32 9AX');
//        $property->setCity('Prestonpans');
//        $property->setCountry('GB');
//        $property->setPrice(125000);
//        $property->setLat(55.959119);
//        $property->setLng(-2.985161);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_4', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_5'));
//        $property->setTerms($this->getReference('term_fixed_price'));
//        $property->setSubType($this->getReference('sub_type_semi_detached_house'));
//        $property->setOnline(true);
//        $property->setStreet('Walker Terrace');
//        $property->setHouseNumber('32');
//        $property->setPostcode('EH40 3AL');
//        $property->setCity('East Linton');
//        $property->setCountry('GB');
//        $property->setPrice(160000);
//        $property->setLat(55.988061);
//        $property->setLng(-2.659492);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_5', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_6'));
//        $property->setTerms($this->getReference('term_offers_over'));
//        $property->setSubType($this->getReference('sub_type_end_terraced_house'));
//        $property->setOnline(true);
//        $property->setStreet('Court Street');
//        $property->setHouseNumber('4C');
//        $property->setPostcode('EH41 3JA');
//        $property->setCity('Haddington');
//        $property->setCountry('GB');
//        $property->setPrice(127500);
//        $property->setLat(55.955799);
//        $property->setLng(-2.779028);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_6', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_7'));
//        $property->setTerms($this->getReference('term_offers_around'));
//        $property->setSubType($this->getReference('sub_type_first_floor_flat'));
//        $property->setOnline(false);
//        $property->setStreet('Inveresk Road');
//        $property->setHouseNumber('7B');
//        $property->setPostcode('EH21 7BJ');
//        $property->setCity('Musselburgh');
//        $property->setCountry('GB');
//        $property->setPrice(95000);
//        $property->setLat(55.940750);
//        $property->setLng(-3.055988);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_7', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_8'));
//        $property->setTerms($this->getReference('term_sold'));
//        $property->setSubType($this->getReference('sub_type_detached_house'));
//        $property->setOnline(true);
//        $property->setStreet('Laburnum Avenue');
//        $property->setHouseNumber('14');
//        $property->setPostcode('EH32 0UD');
//        $property->setCity('Port Seton');
//        $property->setCountry('GB');
//        $property->setPrice(325000);
//        $property->setLat(55.968600);
//        $property->setLng(-2.946050);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_8', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_9'));
//        $property->setTerms($this->getReference('term_sold'));
//        $property->setSubType($this->getReference('sub_type_end_terraced_house'));
//        $property->setOnline(true);
//        $property->setStreet('Lee Crescent');
//        $property->setHouseNumber('21');
//        $property->setPostcode('EH15 1LW');
//        $property->setCity('Portobello');
//        $property->setCountry('GB');
//        $property->setPrice(460000);
//        $property->setLat(55.951748);
//        $property->setLng(-3.114003);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_9', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_10'));
//        $property->setTerms($this->getReference('term_fixed_price'));
//        $property->setSubType($this->getReference('sub_type_detached_house'));
//        $property->setOnline(true);
//        $property->setStreet('Daiches Braes');
//        $property->setHouseNumber('6');
//        $property->setPostcode('EH15 2RF');
//        $property->setCity('Brunstane');
//        $property->setCountry('GB');
//        $property->setPrice(365000);
//        $property->setLat(55.942381);
//        $property->setLng(-3.095684);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_10', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_11'));
//        $property->setTerms($this->getReference('term_fixed_price'));
//        $property->setSubType($this->getReference('sub_type_top_floor_flat'));
//        $property->setOnline(true);
//        $property->setStreet('Waterfront Park');
//        $property->setHouseNumber('41/6');
//        $property->setPostcode('EH5 1EZ');
//        $property->setCity('Granton');
//        $property->setCountry('GB');
//        $property->setPrice(135000);
//        $property->setLat(55.981014);
//        $property->setLng(-3.224955);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_11', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_12'));
//        $property->setTerms($this->getReference('term_sold'));
//        $property->setSubType($this->getReference('sub_type_upper_flat'));
//        $property->setOnline(true);
//        $property->setStreet('Pittville Street');
//        $property->setHouseNumber('25/2');
//        $property->setPostcode('EH15 2BX');
//        $property->setCity('Joppa');
//        $property->setCountry('GB');
//        $property->setPrice(290000);
//        $property->setLat(55.952027);
//        $property->setLng(-3.106079);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_12', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_13'));
//        $property->setTerms($this->getReference('term_offers_around'));
//        $property->setSubType($this->getReference('sub_type_semi_detached_house'));
//        $property->setOnline(true);
//        $property->setStreet('Milton Road West');
//        $property->setHouseNumber('28');
//        $property->setPostcode('EH15 1LE');
//        $property->setCity('Duddingston');
//        $property->setCountry('GB');
//        $property->setPrice(375000);
//        $property->setLat(55.943367);
//        $property->setLng(-3.120353);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_13', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_14'));
//        $property->setTerms($this->getReference('term_offers_around'));
//        $property->setSubType($this->getReference('sub_type_upper_flat'));
//        $property->setOnline(true);
//        $property->setStreet('Gilmerton Dykes Drive');
//        $property->setHouseNumber('86');
//        $property->setPostcode('EH17 8LG');
//        $property->setCity('Gilmerton');
//        $property->setCountry('GB');
//        $property->setPrice(125000);
//        $property->setLat(55.903633);
//        $property->setLng(-3.142633);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_14', $property);
//        $manager->persist($property);
//
//        $property = new Property();
//        $property->setKind($this->getReference('kind_sale'));
//        $property->setAgent($this->getReference('agent_annan_1'));
//        $property->setClient($this->getReference('client_annan_15'));
//        $property->setTerms($this->getReference('term_under_offer'));
//        $property->setSubType($this->getReference('sub_type_upper_flat'));
//        $property->setOnline(false);
//        $property->setStreet('Midmar Drive');
//        $property->setHouseNumber('8');
//        $property->setPostcode('EH10 6BT');
//        $property->setCity('Morningside');
//        $property->setCountry('GB');
//        $property->setPrice(450000);
//        $property->setLat(55.924676);
//        $property->setLng(-3.199477);
//        $property->setEspc(false);
//        $property->setArchived(false);
//        $this->addReference('property_annan_15', $property);
//        $manager->persist($property);
//
//
//        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 30;
    }
}
