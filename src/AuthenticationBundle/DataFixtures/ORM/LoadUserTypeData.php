<?php declare(strict_types=1);

namespace AuthenticationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AuthenticationBundle\Entity\UserType;

/**
 * Class LoadUserTypeData
 * @package AuthenticationBundle\DataFixtures\ORM
 */
class LoadUserTypeData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userType = new UserType();
        $userType->setEn('admin');
        $userType->setNl('beheerder');
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('agent');
        $userType->setNl('makelaar');
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('colleague');
        $userType->setNl('collega');
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('client');
        $userType->setNl('klant');
        $manager->persist($userType);

        $userType = new UserType();
        $userType->setEn('api');
        $userType->setNl('api');
        $manager->persist($userType);

        $manager->flush();
    }
}
