<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PropertyBundle\Entity\SubType;

/**
 * Class LoadSubTypeData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadSubTypeData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Cottage');
        $subType->setNl('Buitenhuis');
        $manager->persist($subType);
        
        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Detached Bungalow');
        $subType->setNl('Vrijstaande Bungalow');
        $manager->persist($subType);
        
        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Detached House');
        $subType->setNl('Vrijstaand Huis');
        $manager->persist($subType);

        $manager->flush();
    }
}
