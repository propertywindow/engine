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
        $user->setUserType($this->getReference('user_type_admin'));
        $user->setAgent($this->getReference('agent_1'));
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
        $this->addReference('user_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_admin'));
        $user->setAgent($this->getReference('agent_2'));
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
        $this->addReference('user_2', $user);
        $manager->persist($user);


        for ($i = 3; $i <= 10; $i++) {
            $path     = file_get_contents('https://randomuser.me/api/?nat=gb');
            $json     = json_decode($path, true);
            $fakeUser = $json['results'][0];
            $matches  = [];

            if (preg_match('/(?P<number>\d+.?) (?P<street>[^\d]+)/', $fakeUser['location']['street'], $matches)) {
                $houseNumber = $matches['number'];
                $street      = $matches['street'];

                $user = new User();
                $user->setUserType($this->getReference('user_type_client'));
                $user->setAgent($this->getReference('agent_1'));
                $user->setUsername($fakeUser['login']['username']);
                $user->setPassword($fakeUser['login']['md5']);
                $user->setEmail($fakeUser['email']);
                $user->setFirstName(ucfirst($fakeUser['name']['first']));
                $user->setLastName(ucfirst($fakeUser['name']['last']));
                $user->setStreet(ucwords($street));
                $user->setHouseNumber($houseNumber);
                $user->setPostcode($fakeUser['location']['postcode']);
                $user->setCity(ucwords($fakeUser['location']['city']));
                $user->setCountry('GB');
                $user->setPhone($fakeUser['phone']);
                $user->setAvatar($fakeUser['picture']['large']);
                $this->addReference('user_'.$i, $user);
                $manager->persist($user);
            }
        }

        $manager->flush();
    }


    /**
     * @return integer
     */
    public function getOrder()
    {
        return 16;
    }
}
