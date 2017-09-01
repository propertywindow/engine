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
        // Admin Users

        $user = new User();
        $user->setUserType($this->getReference('user_type_admin'));
        $user->setAgent($this->getReference('agent_1'));
        $user->setEmail('geurtsmarc@hotmail.com');
        $user->setPassword(md5('marc'));
        $user->setFirstName('Marc');
        $user->setLastName('Geurts');
        $user->setStreet('Graafsedijk');
        $user->setHouseNumber('19');
        $user->setPostcode('5437 NG');
        $user->setCity('Beers');
        $user->setCountry('NL');
        $user->setActive(true);
        $this->addReference('user_admin_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_admin'));
        $user->setAgent($this->getReference('agent_2'));
        $user->setEmail('iain@datacomputerservices.co.uk');
        $user->setPassword(md5('iain'));
        $user->setFirstName('Iain');
        $user->setLastName('Anderson');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('27');
        $user->setPostcode('EH15 1DE');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_admin_2', $user);
        $manager->persist($user);


        // Client Users

        for ($i = 1; $i <= 5; $i++) {
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
                $user->setEmail($fakeUser['email']);
                $user->setPassword($fakeUser['login']['md5']);
                $user->setFirstName(ucfirst($fakeUser['name']['first']));
                $user->setLastName(ucfirst($fakeUser['name']['last']));
                $user->setStreet(ucwords($street));
                $user->setHouseNumber($houseNumber);
                $user->setPostcode($fakeUser['location']['postcode']);
                $user->setCity(ucwords($fakeUser['location']['city']));
                $user->setCountry('GB');
                $user->setPhone($fakeUser['phone']);
                $user->setAvatar($fakeUser['picture']['large']);
                $user->setActive(false);
                $this->addReference('user_client_'.$i, $user);
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
