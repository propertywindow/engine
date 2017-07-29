<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PropertyBundle\Entity\Type;

/**
 * Class LoadTypeData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadTypeData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $type = new Type();
        $type->setEn('House');
        $type->setNl('Huis');
        $manager->persist($type);
        
        $type = new Type();
        $type->setEn('Flat');
        $type->setNl('Flat');
        $manager->persist($type);
        
        $type = new Type();
        $type->setEn('Other');
        $type->setNl('Overige');
        $manager->persist($type);

        $manager->flush();
    }
}
