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
        $gallery = new Gallery();
        $gallery->setSort(1);
        $gallery->setPath('http://www.live.web-print.co.uk/Client_38/593eafc1_1_1lo.jpg');
        $gallery->setMain(true);
        $gallery->setProperty($this->getReference('property_annan_1'));
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setSort(2);
        $gallery->setPath('http://www.live.web-print.co.uk/Client_38/593eafc1_1_3lo.jpg');
        $gallery->setProperty($this->getReference('property_annan_1'));
        $manager->persist($gallery);

        $gallery = new Gallery();
        $gallery->setSort(3);
        $gallery->setPath('http://www.live.web-print.co.uk/Client_38/593eafc1_1_4lo.jpg');
        $gallery->setProperty($this->getReference('property_annan_1'));
        $manager->persist($gallery);







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
