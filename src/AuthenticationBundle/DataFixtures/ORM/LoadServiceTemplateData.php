<?php declare(strict_types=1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\ServiceTemplate;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadServiceTemplateData
 * @package AuthenticationBundle\DataFixtures\ORM
 */
class LoadServiceTemplateData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_view_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_add_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_edit_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_delete_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $serviceTemplate = new ServiceTemplate();
        $serviceTemplate->setService($this->getReference('service_archive_property'));
        $serviceTemplate->setUserType($this->getReference('user_type_admin'));
        $manager->persist($serviceTemplate);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 12;
    }
}
