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
        $user->setAgent($this->getReference('agent_propertywindow_1'));
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
        $user->setAgent($this->getReference('agent_propertywindow_1'));
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

        // Property Window Agents

        $user = new User();
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_propertywindow_1'));
        $user->setEmail('info@propertywindow.com');
        $user->setPassword(md5('antica'));
        $user->setFirstName('Antica');
        $user->setLastName('Culina');
        $user->setStreet('Portobello High Street');
        $user->setHouseNumber('27');
        $user->setPostcode('EH15 1DE');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_propertywindow_agent_1', $user);
        $manager->persist($user);

        // Annan Agents

        $user = new User();
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('edinburgh@annan.co.uk');
        $user->setPassword(md5('edinburgh'));
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
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_annan_2'));
        $user->setEmail('lothian@annan.co.uk');
        $user->setPassword(md5('michael'));
        $user->setFirstName('Michael');
        $user->setLastName('Annan');
        $user->setStreet('High Street');
        $user->setHouseNumber('84');
        $user->setPostcode('EH21 7BX');
        $user->setCity('Musselburgh');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_annan_agent_2', $user);
        $manager->persist($user);

        // Oliver Agents

        $user = new User();
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_oliver_1'));
        $user->setEmail('joliver@gandjoliver.co.uk');
        $user->setPassword(md5('joliver'));
        $user->setFirstName('Jan');
        $user->setLastName('Oliver');
        $user->setStreet('High Street');
        $user->setHouseNumber('13');
        $user->setPostcode('TD9 9DH');
        $user->setCity('Hawick');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_oliver_agent_1', $user);
        $manager->persist($user);

        // Deans Agents

        $user = new User();
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_deans_1'));
        $user->setEmail('newington@deansproperties.co.uk');
        $user->setPassword(md5('newington'));
        $user->setFirstName('Deans');
        $user->setLastName('Newington');
        $user->setStreet('St Patrick Street');
        $user->setHouseNumber('3');
        $user->setPostcode('EH8 9ES');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_deans_agent_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_deans_2'));
        $user->setEmail('corstorphine@deansproperties.co.uk');
        $user->setPassword(md5('corstorphine'));
        $user->setFirstName('Deans');
        $user->setLastName('Corstorphine');
        $user->setStreet('St Johns Road');
        $user->setHouseNumber('135-137');
        $user->setPostcode('EH12 7SB');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_deans_agent_2', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_agent'));
        $user->setAgent($this->getReference('agent_deans_3'));
        $user->setEmail('southqueensferry@deansproperties.co.uk');
        $user->setPassword(md5('southqueensferry'));
        $user->setFirstName('Deans');
        $user->setLastName('Queensferry');
        $user->setStreet('High Street');
        $user->setHouseNumber('31A');
        $user->setPostcode('EH30 9PP');
        $user->setCity('Edinburgh');
        $user->setCountry('GB');
        $user->setActive(true);
        $this->addReference('user_deans_agent_3', $user);
        $manager->persist($user);

        // Annan Colleagues

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_annan_1'));
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
        $user->setAvatar('2/users/10.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_annan_1'));
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
        $user->setAvatar('2/users/11.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_2', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_annan_1'));
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
        $user->setAvatar('2/users/12.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_3', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_annan_1'));
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
        $user->setAvatar('2/users/13.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_4', $user);
        $manager->persist($user);


        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_annan_2'));
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
        $user->setAvatar('2/users/14.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_5', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_colleague'));
        $user->setAgent($this->getReference('agent_annan_2'));
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
        $user->setAvatar('2/users/15.jpg');
        $user->setActive(true);
        $this->addReference('user_annan_colleague_6', $user);
        $manager->persist($user);

        // Annan Clients

        for ($i = 1; $i <= 15; $i++) {
            $path     = file_get_contents('https://randomuser.me/api/?nat=gb');
            $json     = json_decode($path, true);
            $fakeUser = $json['results'][0];
            $matches  = [];

            if (preg_match('/(?P<number>\d+.?) (?P<street>[^\d]+)/', $fakeUser['location']['street'], $matches)) {
                $houseNumber = $matches['number'];
                $street      = $matches['street'];

                $user = new User();
                $user->setUserType($this->getReference('user_type_client'));
                $user->setAgent($this->getReference('agent_annan_1'));
                $user->setEmail($fakeUser['email']);
                $user->setPassword($fakeUser['login']['md5']);
                $user->setFirstName(ucfirst($fakeUser['name']['first']));
                $user->setLastName(ucfirst($fakeUser['name']['last']));
                $user->setStreet(ucwords($street));
                $user->setHouseNumber($houseNumber);
                $user->setPostcode($fakeUser['location']['postcode']);
                $user->setCity(ucwords($fakeUser['location']['city']));
                $user->setCountry('GB');
                $user->setPhone($fakeUser['cell']);
                $user->setActive(false);
                $this->addReference('user_annan_client_'.$i, $user);
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
