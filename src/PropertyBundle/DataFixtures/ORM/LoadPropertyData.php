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
        $property = new Property();
        $property->setKind($this->getReference('kind_sale'));
        $property->setAgent($this->getReference('agent_1'));
        $property->setClient($this->getReference('client_1'));
        $property->setTerms($this->getReference('term_fixed_price'));
        $property->setOnline(true);
        $property->setSubType(2);
        $property->setStreet('Graafsedijk');
        $property->setHouseNumber('19');
        $property->setPostcode('5437 NG');
        $property->setCity('Beers');
        $property->setCountry('NL');
        $property->setPrice(350500);
        $property->setLat(51.71832819999999);
        $property->setLng(5.812249999999949);
        $property->setEspc(false);
        $property->setArchived(false);
        $this->addReference('property_1', $property);
        $manager->persist($property);

        $property = new Property();
        $property->setKind($this->getReference('kind_sale'));
        $property->setAgent($this->getReference('agent_2'));
        $property->setClient($this->getReference('client_1'));
        $property->setTerms($this->getReference('term_new'));
        $property->setOnline(true);
        $property->setSubType(1);
        $property->setStreet('Portobello High Street');
        $property->setHouseNumber('27');
        $property->setPostcode('EH15 1DE');
        $property->setCity('Edinburgh');
        $property->setCountry('GB');
        $property->setPrice(250500);
        $property->setLat(55.9553591);
        $property->setLng(-3.1188563000000613);
        $property->setEspc(false);
        $property->setArchived(false);
        $this->addReference('property_2', $property);
        $manager->persist($property);

        $property = new Property();
        $property->setKind($this->getReference('kind_sale'));
        $property->setAgent($this->getReference('agent_1'));
        $property->setClient($this->getReference('client_2'));
        $property->setTerms($this->getReference('term_new'));
        $property->setOnline(true);
        $property->setSubType(12);
        $property->setStreet('Silverbuthall Road');
        $property->setHouseNumber('56');
        $property->setPostcode('TD9 7BN');
        $property->setCity('Hawick');
        $property->setCountry('GB');
        $property->setPrice(90000);
        $property->setLat(55.4324969);
        $property->setLng(-2.7873451000000387);
        $property->setEspc(false);
        $property->setArchived(false);
        $this->addReference('property_3', $property);
        $manager->persist($property);

        $property = new Property();
        $property->setKind($this->getReference('kind_sale'));
        $property->setAgent($this->getReference('agent_1'));
        $property->setClient($this->getReference('client_3'));
        $property->setTerms($this->getReference('term_new'));
        $property->setOnline(true);
        $property->setSubType(12);
        $property->setStreet('Borthaugh Road');
        $property->setHouseNumber('26');
        $property->setPostcode('TD9 0BZ');
        $property->setCity('Hawick');
        $property->setCountry('GB');
        $property->setPrice(105000);
        $property->setLat(55.4180338);
        $property->setLng(-2.8005752000000257);
        $property->setEspc(false);
        $property->setArchived(false);
        $this->addReference('property_4', $property);
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
