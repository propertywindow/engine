<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\Kind;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadKindData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadKindData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $kind = new Kind();
        $kind->setEn('Sale');
        $kind->setNl('Koop');
        $this->addReference('kind_sale', $kind);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setEn('Let');
        $kind->setNl('Huur');
        $this->addReference('kind_let', $kind);
        $manager->persist($kind);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}
