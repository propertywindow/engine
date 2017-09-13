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

        for ($i = 1; $i <= 20; $i++) {
            $main = ($i === 1) ? true : false;
            $gallery = new Gallery();
            $gallery->setSort($i);
            $gallery->setPath('4/properties/1/'.$i.'.jpg');
            $gallery->setMain($main);
            $gallery->setProperty($this->getReference('property_annan_1'));
            $manager->persist($gallery);
        }

        for ($i = 1; $i <= 20; $i++) {
            $main = ($i === 1) ? true : false;
            $gallery = new Gallery();
            $gallery->setSort($i);
            $gallery->setPath('4/properties/2/'.$i.'.jpg');
            $gallery->setMain($main);
            $gallery->setProperty($this->getReference('property_annan_2'));
            $manager->persist($gallery);
        }

        for ($i = 1; $i <= 20; $i++) {
            $main = ($i === 1) ? true : false;
            $gallery = new Gallery();
            $gallery->setSort($i);
            $gallery->setPath('4/properties/3/'.$i.'.jpg');
            $gallery->setMain($main);
            $gallery->setProperty($this->getReference('property_annan_3'));
            $manager->persist($gallery);
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
