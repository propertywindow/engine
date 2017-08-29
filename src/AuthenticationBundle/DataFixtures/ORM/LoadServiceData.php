<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\Service;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadServiceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $service = new Service();
        $service->setEn('View Property');
        $service->setNl('Bekijk Woning');
        $service->setIcon('zmdi zmdi zmdi-city-alt');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Add Property');
        $service->setNl('Woning Toevoegen');
        $service->setIcon('zmdi zmdi zmdi-city-alt');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Edit Property');
        $service->setNl('Bewerk Woning');
        $service->setIcon('zmdi zmdi zmdi-city-alt');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $service = new Service();
        $service->setEn('Delete Property');
        $service->setNl('Verwijder Woning');
        $service->setIcon('zmdi zmdi zmdi-city-alt');
        $service->setVisible(true);
        $service->setServiceGroup($this->getReference('service_group_properties'));
        $manager->persist($service);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 11;
    }
}
