<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\Gallery;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadGalleryData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadGalleryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Annan Properties

        for ($i = 1; $i <= 15; $i++) {
            for ($g = 1; $g <= 20; $g++) {
                $main    = ($g === 1) ? true : false;
                $gallery = new Gallery();
                $gallery->setSort($g);
                $gallery->setPath('2/properties/'.$i.'/'.$g.'.jpg');
                $gallery->setMain($main);
                $gallery->setProperty($this->getReference('property_annan_' . $i));
                $manager->persist($gallery);
            }
        }

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 31;
    }
}
