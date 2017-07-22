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

        $user->setTypeId(1);
        $user->setUsername('marc');
        $user->setPassword('marc');
        $user->setEmail('geurtsmarc@hotmail.com');
        $user->setFirstName('Marc');
        $user->setLastName('Geurts');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('27');
        $user->setPostcode('EH15 1DE');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');

        $manager->persist($user);

        $manager->flush();
    }
}
