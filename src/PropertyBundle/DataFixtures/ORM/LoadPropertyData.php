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
