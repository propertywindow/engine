<?php declare(strict_types=1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\UserType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadUserTypeData
 * @package AuthenticationBundle\DataFixtures\ORM
 */
class LoadUserTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userType = new UserType();
        $userType->setEn('admin');
        $userType->setNl('beheerder');
        $userType->setVisible(true);
        $this->addReference('user_type_admin', $userType);
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('agent');
        $userType->setNl('makelaar');
        $userType->setVisible(true);
        $this->addReference('user_type_agent', $userType);
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('colleague');
        $userType->setNl('collega');
        $userType->setVisible(true);
        $this->addReference('user_type_colleague', $userType);
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('client');
        $userType->setNl('klant');
        $userType->setVisible(true);
        $this->addReference('user_type_client', $userType);
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('api');
        $userType->setNl('api');
        $userType->setVisible(false);
        $this->addReference('user_type_api', $userType);
        $manager->persist($userType);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 15;
    }
}
