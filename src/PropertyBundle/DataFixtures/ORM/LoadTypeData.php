<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\Type;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadTypeData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $type = new Type();
        $type->setEn('House');
        $type->setNl('Huis');
        $this->addReference('type_house', $type);
        $manager->persist($type);
        
        $type = new Type();
        $type->setEn('Flat');
        $type->setNl('Flat');
        $this->addReference('type_flat', $type);
        $manager->persist($type);
        
        $type = new Type();
        $type->setEn('Other');
        $type->setNl('Overige');
        $this->addReference('type_other', $type);
        $manager->persist($type);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
