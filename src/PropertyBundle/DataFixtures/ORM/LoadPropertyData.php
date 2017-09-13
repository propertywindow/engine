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
        $property->setAgent($this->getReference('agent_6'));
        $property->setClient($this->getReference('client_annan_1'));
        $property->setTerms($this->getReference('term_offers_over'));
        $property->setOnline(true);
        $property->setSubType(2);
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
