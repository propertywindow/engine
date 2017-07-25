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
        $property->setStatus(1);
        $property->setOnline(1);
        $property->setSubType(1);
        $property->setStreet('27 Portobello High Street');
        $property->setHouseNumber(10);
        $property->setPostcode('EH15 1DE');
        $property->setCity('Edinburgh');
        $property->setCountry('GB');
        $property->setPrice(250500);
        $property->setLat(1);
        $property->setLng(1);
        $property->setEspc(false);
        $property->setArchived(false);

        $manager->persist($property);

        $manager->flush();


//        for ($i = 33284; $i <= 33300; $i++) {
//            $json = file_get_contents(
//                'http://propertywindow.com/login2/ajax/properties_sale/view_property.php?ID='. $i
//            );
//            $obj  = json_decode($json);
//
//            if (isset($obj->ID)) {
//                $property = new Property();
//                $property->setKind('sale');
//                $property->setAgentId(1);
//                $property->setStatus($obj->StatusRef);
//                $property->setOnline(1);
//                $property->setSubType($obj->SubTypeRef);
//
//                $property->setStreet($obj->Address);
//                $property->setHouseNumber(10);
//                $property->setPostcode($obj->Postcode);
//                $property->setCity($obj->SubArea);
//                $property->setCountry('GB');
//                $property->setPrice($obj->Price);
//                $property->setLat(1);
//                $property->setLng(1);
//                $property->setEspc(false);
//                $property->setArchived($obj->Archived);
//
//                $manager->persist($property);
//            }
//        }
//
//        $manager->flush();
    }
}
