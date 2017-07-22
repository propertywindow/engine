<?php declare(strict_types=1);

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AuthenticationBundle\Entity\User;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadUserData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('marc');
        $user->setPassword('marc');
        $user->setEmail('geurtsmarc@hotmail.com');
        $user->setAddress('27 Portobello High Street');
        $user->setPostcode('EH15 1DE');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');

        $manager->persist($user);

        $manager->flush();
    }
}
