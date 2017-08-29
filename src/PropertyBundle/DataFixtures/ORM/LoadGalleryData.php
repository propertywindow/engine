<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PropertyBundle\Entity\Gallery;

/**
 * Class LoadGalleryData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadGalleryData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $gallery = new Gallery();
        $gallery->setPropertyId(1);
        $gallery->setSort(1);
        $gallery->setPath('imagePath1');
        $gallery->setMain(true);
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setPropertyId(1);
        $gallery->setSort(2);
        $gallery->setPath('imagePath2');
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setPropertyId(1);
        $gallery->setSort(3);
        $gallery->setPath('imagePath3');
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setPropertyId(2);
        $gallery->setSort(1);
        $gallery->setPath('imagePath1');
        $gallery->setMain(true);
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setPropertyId(2);
        $gallery->setSort(2);
        $gallery->setPath('imagePath2');
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setPropertyId(2);
        $gallery->setSort(3);
        $gallery->setPath('imagePath3');
        $manager->persist($gallery);

        $manager->flush();
    }
}
