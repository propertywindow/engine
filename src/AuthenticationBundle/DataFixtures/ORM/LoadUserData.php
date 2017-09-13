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
        // todo: only in dev environment

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
        $user->setAvatar('1/users/1.jpg');
        $this->addReference('user_propertywindow_admin_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_admin'));
        $user->setAgent($this->getReference('agent_1'));
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
        $this->addReference('user_propertywindow_admin_2', $user);
        $manager->persist($user);

        // Annan Users

        $user = new User();
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('info@annan.co.uk');
        $user->setPassword(md5('michael'));
        $user->setFirstName('Michael');
        $user->setLastName('Annan');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('229');
        $user->setPostcode('EH15 2AN');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_annan_agent_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('michael@annan.co.uk');
        $user->setPassword(md5('michael'));
        $user->setFirstName('Michael');
        $user->setLastName('Annan');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('229');
        $user->setPostcode('EH15 2AN');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setPhone('07773777771');
        $user->setAvatar('4/users/4.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('alex@annan.co.uk');
        $user->setPassword(md5('alexander'));
        $user->setFirstName('Alexander');
        $user->setLastName('Scott');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('229');
        $user->setPostcode('EH15 2AN');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setPhone('07951172592');
        $user->setAvatar('4/users/5.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_2', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('gill@annan.co.uk');
        $user->setPassword(md5('gill'));
        $user->setFirstName('Gill');
        $user->setLastName('Cruickshank');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('229');
        $user->setPostcode('EH15 2AN');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setPhone('07803950770');
        $user->setAvatar('4/users/6.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_3', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('kirsten@annan.co.uk');
        $user->setPassword(md5('kirsten'));
        $user->setFirstName('Kirsten');
        $user->setLastName('McArdle');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('229');
        $user->setPostcode('EH15 2AN');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setPhone('07950613000');
        $user->setAvatar('4/users/7.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_4', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_7'));
        $user->setEmail('blair@annan.co.uk');
        $user->setPassword(md5('blair'));
        $user->setFirstName('Blair');
        $user->setLastName('Ross');
        $user->setStreet('High Street');
        $user->setHouseNumber('84');
        $user->setPostcode('EH21 7BX');
        $user->setCity('Musselburgh');
        $user->setCountry('GB');
        $user->setPhone('07815545405');
        $user->setAvatar('4/users/8.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_5', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_7'));
        $user->setEmail('david@annan.co.uk');
        $user->setPassword(md5('david'));
        $user->setFirstName('David');
        $user->setLastName('Currie');
        $user->setStreet('High Street');
        $user->setHouseNumber('84');
        $user->setPostcode('EH21 7BX');
        $user->setCity('Musselburgh');
        $user->setCountry('GB');
        $user->setPhone('07713793181');
        $user->setAvatar('4/users/9.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_6', $user);
        $manager->persist($user);

        // Annan Clients

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('carolyn.clarke@example.com');
        $user->setPassword(md5('slugger'));
        $user->setFirstName('Carolyn');
        $user->setLastName('Clarke');
        $user->setStreet('Main street');
        $user->setHouseNumber('5204');
        $user->setPostcode('E1 9ZU');
        $user->setCity('Winchester');
        $user->setCountry('GB');
        $user->setPhone('0776291407');
        $user->setActive(true);
        $this->addReference('user_annan_client_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('shane.rogers@example.com');
        $user->setPassword(md5('homepage'));
        $user->setFirstName('Shane');
        $user->setLastName('Rogers');
        $user->setStreet('North road');
        $user->setHouseNumber('4337');
        $user->setPostcode('M4 4GP');
        $user->setCity('Birmingham');
        $user->setCountry('GB');
        $user->setPhone('0760070775');
        $user->setActive(true);
        $this->addReference('user_annan_client_2', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_6'));
        $user->setEmail('peter.parker@example.com');
        $user->setPassword(md5('zero'));
        $user->setFirstName('Peter');
        $user->setLastName('Parker');
        $user->setStreet('Park avenue');
        $user->setHouseNumber('3034');
        $user->setPostcode('IC9F 6JX');
        $user->setCity('Nottingham');
        $user->setCountry('GB');
        $user->setPhone('0726923361');
        $user->setActive(true);
        $this->addReference('user_annan_client_3', $user);
        $manager->persist($user);




        // Client Users

//        for ($i = 1; $i <= 2; $i++) {
//            $GB       = 'GB';
//            $NL       = 'NL';
//            $country  = mt_rand(0, 1) ? $GB : $NL;
//            $path     = file_get_contents('https://randomuser.me/api/?nat='.strtolower($country));
//            $json     = json_decode($path, true);
//            $fakeUser = $json['results'][0];
//            $matches  = [];
//
//            if (preg_match('/(?P<number>\d+.?) (?P<street>[^\d]+)/', $fakeUser['location']['street'], $matches)) {
//                $houseNumber = $matches['number'];
//                $street      = $matches['street'];
//
//                $user = new User();
//                $user->setUserType($this->getReference('user_type_client'));
//                $user->setAgent($this->getReference('agent_6'));
//                $user->setEmail($fakeUser['email']);
//                $user->setPassword($fakeUser['login']['md5']);
//                $user->setFirstName(ucfirst($fakeUser['name']['first']));
//                $user->setLastName(ucfirst($fakeUser['name']['last']));
//                $user->setStreet(ucwords($street));
//                $user->setHouseNumber($houseNumber);
//                $user->setPostcode($fakeUser['location']['postcode']);
//                $user->setCity(ucwords($fakeUser['location']['city']));
//                $user->setCountry($country);
//                $user->setPhone($fakeUser['phone']);
//                $user->setAvatar($fakeUser['picture']['large']);
//                $user->setActive(false);
//                $this->addReference('user_client_'.$i, $user);
//                $manager->persist($user);
//            }
//        }

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
