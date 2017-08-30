<?php declare(strict_types=1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadUserData
 * @package AuthenticationBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setTypeId(1);
        $user->setAgentId(1);
        $user->setUsername('marc');
        $user->setPassword(md5('marc'));
        $user->setEmail('geurtsmarc@hotmail.com');
        $user->setFirstName('Marc');
        $user->setLastName('Geurts');
        $user->setStreet('Graafsedijk');
        $user->setHouseNumber('19');
        $user->setPostcode('5437 NG');
        $user->setCity('Beers');
        $user->setCountry('NL');
        $manager->persist($user);

        $user = new User();
        $user->setTypeId(1);
        $user->setAgentId(2);
        $user->setUsername('iain');
        $user->setPassword(md5('iain'));
        $user->setEmail('iain@datacomputerservices.co.uk');
        $user->setFirstName('Iain');
        $user->setLastName('Anderson');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('27');
        $user->setPostcode('EH15 1DE');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $manager->persist($user);

        $user = new User();
        $user->setTypeId(4);
        $user->setAgentId(1);
        $user->setUsername('marc');
        $user->setPassword(md5('marc'));
        $user->setEmail('geurtsmarc@hotmail.com');
        $user->setFirstName('Marc');
        $user->setLastName('Geurts');
        $user->setStreet('Graafsedijk');
        $user->setHouseNumber('19');
        $user->setPostcode('5437 NG');
        $user->setCity('Beers');
        $user->setCountry('NL');
        $manager->persist($user);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}
