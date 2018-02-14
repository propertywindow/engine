<?php
declare(strict_types = 1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\Type;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadType Data
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
        $this->setReference('type_house', $type);
        $manager->persist($type);

        $type = new Type();
        $type->setEn('Flat');
        $type->setNl('Flat');
        $this->setReference('type_flat', $type);
        $manager->persist($type);

        $type = new Type();
        $type->setEn('Other');
        $type->setNl('Overige');
        $this->setReference('type_other', $type);
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
