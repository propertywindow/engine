<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PropertyBundle\Entity\Property;

/**
 * Class LoadPropertyData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadPropertyData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $property = new Property();
        $property->setKind('sale');
        $property->setAgentId(1);
        $property->setClientId(1);
        $property->setStatus(1);
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

        $property = new Property();
        $property->setKind('sale');
        $property->setAgentId(2);
        $property->setClientId(1);
        $property->setStatus(1);
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

        $manager->flush();
    }
}
