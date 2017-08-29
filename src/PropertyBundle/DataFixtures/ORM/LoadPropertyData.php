<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\Gallery;
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
        $property->setKind('sale');
        $property->setAgent($this->getReference('agent_1'));
        $property->setClientId(1);
        $property->setTerms(1);
        $property->setOnline(1);
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
        $manager->persist($property);

        $gallery = new Gallery();
        $gallery->setSort(1);
        $gallery->setPath('imagePath1');
        $gallery->setMain(true);
        $gallery->setProperty($property);
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setSort(2);
        $gallery->setPath('imagePath2');
        $gallery->setProperty($property);
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setSort(3);
        $gallery->setPath('imagePath3');
        $gallery->setProperty($property);
        $manager->persist($gallery);


        $property = new Property();
        $property->setKind('sale');
        $property->setAgent($this->getReference('agent_2'));
        $property->setClientId(1);
        $property->setTerms(1);
        $property->setOnline(1);
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
        $manager->persist($property);

        $gallery = new Gallery();
        $gallery->setSort(1);
        $gallery->setPath('imagePath1');
        $gallery->setMain(true);
        $gallery->setProperty($property);
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setSort(2);
        $gallery->setPath('imagePath2');
        $gallery->setProperty($property);
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setSort(3);
        $gallery->setPath('imagePath3');
        $gallery->setProperty($property);
        $manager->persist($gallery);


        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}
