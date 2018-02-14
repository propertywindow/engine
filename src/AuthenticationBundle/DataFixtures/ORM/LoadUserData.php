<?php
declare(strict_types=1);

namespace AuthenticationBundle\DataFixtures\ORM;

use AuthenticationBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadUserData
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
        $this->setReference('user_propertywindow_admin_1', $user);
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
        $this->setReference('user_propertywindow_admin_2', $user);
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
        $this->setReference('user_propertywindow_agent_1', $user);
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
        $this->setReference('user_annan_agent_1', $user);
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
        $this->setReference('user_annan_agent_2', $user);
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
        $this->setReference('user_oliver_agent_1', $user);
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
        $this->setReference('user_deans_agent_1', $user);
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
        $this->setReference('user_deans_agent_2', $user);
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
        $this->setReference('user_deans_agent_3', $user);
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
        $this->setReference('user_annan_colleague_1', $user);
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
        $this->setReference('user_annan_colleague_2', $user);
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
        $this->setReference('user_annan_colleague_3', $user);
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
        $this->setReference('user_annan_colleague_4', $user);
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
        $this->setReference('user_annan_colleague_5', $user);
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
        $this->setReference('user_annan_colleague_6', $user);
        $manager->persist($user);

        // Annan Clients

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('tristan.hicks@example.com');
        $user->setPassword('70a3ea03a3adb9ec298e6def78309b21');
        $user->setFirstName('Tristan');
        $user->setLastName('Hicks');
        $user->setStreet('Highfield Road');
        $user->setHouseNumber('9124');
        $user->setPostcode('EC6 5JQ');
        $user->setCity('Stoke-on-trent');
        $user->setCountry('GB');
        $user->setPhone('0777-304-057');
        $user->setActive(false);
        $this->setReference('user_annan_client_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('abigail.gibson@example.com');
        $user->setPassword('c50845615ba9489033ec7011db00b5aa');
        $user->setFirstName('Abigail');
        $user->setLastName('Gibson');
        $user->setStreet('Chester Road');
        $user->setHouseNumber('2168');
        $user->setPostcode('TE8Z 3DN');
        $user->setCity('Bath');
        $user->setCountry('GB');
        $user->setPhone('0733-584-718');
        $user->setActive(false);
        $this->setReference('user_annan_client_2', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('hanna.white@example.com');
        $user->setPassword('a112323f643bf5847b494560422faa28');
        $user->setFirstName('Hanna');
        $user->setLastName('White');
        $user->setStreet('York Road');
        $user->setHouseNumber('9530');
        $user->setPostcode('BF3A 6NF');
        $user->setCity('Manchester');
        $user->setCountry('GB');
        $user->setPhone('0771-352-802');
        $user->setActive(false);
        $this->setReference('user_annan_client_3', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('steven.rogers@example.com');
        $user->setPassword('2e8152aa4b5289f9969ff1e6fdccbbcf');
        $user->setFirstName('Steven');
        $user->setLastName('Rogers');
        $user->setStreet('Queensway');
        $user->setHouseNumber('8154');
        $user->setPostcode('R25 1JH');
        $user->setCity('Newcastle Upon Tyne');
        $user->setCountry('GB');
        $user->setPhone('0708-608-084');
        $user->setActive(false);
        $this->setReference('user_annan_client_4', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('johnny.matthews@example.com');
        $user->setPassword('f82bf98ea17f7a615615fa56466cb9b3');
        $user->setFirstName('Johnny');
        $user->setLastName('Matthews');
        $user->setStreet('York Road');
        $user->setHouseNumber('3595');
        $user->setPostcode('D1M 6GZ');
        $user->setCity('Preston');
        $user->setCountry('GB');
        $user->setPhone('0711-633-034');
        $user->setActive(false);
        $this->setReference('user_annan_client_5', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('bryan.crawford@example.com');
        $user->setPassword('8cb2ad77daa7ecfe3d2e58724babfad5');
        $user->setFirstName('Bryan');
        $user->setLastName('Crawford');
        $user->setStreet('South Street');
        $user->setHouseNumber('7600');
        $user->setPostcode('T04 5UU');
        $user->setCity('Wolverhampton');
        $user->setCountry('GB');
        $user->setPhone('0794-384-088');
        $user->setActive(false);
        $this->setReference('user_annan_client_6', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('debra.curtis@example.com');
        $user->setPassword('8568b7c4c11e31c1c017097eb633baed');
        $user->setFirstName('Debra');
        $user->setLastName('Curtis');
        $user->setStreet('Main Street');
        $user->setHouseNumber('7417');
        $user->setPostcode('ZU31 2SE');
        $user->setCity('Winchester');
        $user->setCountry('GB');
        $user->setPhone('0744-469-763');
        $user->setActive(false);
        $this->setReference('user_annan_client_7', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('soham.powell@example.com');
        $user->setPassword('069250529a3b600e3e24d1633d169eb6');
        $user->setFirstName('Soham');
        $user->setLastName('Powell');
        $user->setStreet('The Grove');
        $user->setHouseNumber('6925');
        $user->setPostcode('T04 5UU');
        $user->setCity('Glasgow');
        $user->setCountry('GB');
        $user->setPhone('0716-708-782');
        $user->setActive(false);
        $this->setReference('user_annan_client_8', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('ben.anderson@example.com');
        $user->setPassword('71ddasd3d1b4db9f04951fasdass4d6b');
        $user->setFirstName('Ben');
        $user->setLastName('Anderson');
        $user->setStreet('School Lane');
        $user->setHouseNumber('8165');
        $user->setPostcode('HG0 2GG');
        $user->setCity('Norwich');
        $user->setCountry('GB');
        $user->setPhone('0772-287-090');
        $user->setActive(false);
        $this->setReference('user_annan_client_9', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('luis.carroll@example.com');
        $user->setPassword('71dd66bdd1b4db9f04951fe0b02b4d6b');
        $user->setFirstName('Luis');
        $user->setLastName('Carroll');
        $user->setStreet('Chester Road');
        $user->setHouseNumber('3336');
        $user->setPostcode('X0I 4HX');
        $user->setCity('St Albans');
        $user->setCountry('GB');
        $user->setPhone('0708-819-216');
        $user->setActive(false);
        $this->setReference('user_annan_client_10', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('carl.weaver@example.com');
        $user->setPassword('3e53775b8c20e27d6c6d2731c1ab3319');
        $user->setFirstName('Carl');
        $user->setLastName('Weaver');
        $user->setStreet('Grove Road');
        $user->setHouseNumber('5394');
        $user->setPostcode('IZ0 8FY');
        $user->setCity('Norwich');
        $user->setCountry('GB');
        $user->setPhone('0745-558-552');
        $user->setActive(false);
        $this->setReference('user_annan_client_11', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('mia.lowe@example.com');
        $user->setPassword('a1320ba54a37b0470494f09b57565152');
        $user->setFirstName('Mia');
        $user->setLastName('Lowe');
        $user->setStreet('Queensway');
        $user->setHouseNumber('7129');
        $user->setPostcode('Y1T 7GZ');
        $user->setCity('Hereford');
        $user->setCountry('GB');
        $user->setPhone('0714-178-492');
        $user->setActive(false);
        $this->setReference('user_annan_client_12', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('clifton.macrae@example.com');
        $user->setPassword('13f1e8636da4b50a8e8ea5c08273d882');
        $user->setFirstName('Clifton');
        $user->setLastName('Macrae');
        $user->setStreet('Station Road');
        $user->setHouseNumber('7140');
        $user->setPostcode('UD45 7US');
        $user->setCity('City Of London');
        $user->setCountry('GB');
        $user->setPhone('0770-827-159');
        $user->setActive(false);
        $this->setReference('user_annan_client_13', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('russell.gonzales@example.com');
        $user->setPassword('e87ca42d38852b16126099a1b9c0bd9f');
        $user->setFirstName('Russell');
        $user->setLastName('Gonzales');
        $user->setStreet('The Green');
        $user->setHouseNumber('7818');
        $user->setPostcode('F5J 8AZ');
        $user->setCity('Canterbury');
        $user->setCountry('GB');
        $user->setPhone('0721-472-470');
        $user->setActive(false);
        $this->setReference('user_annan_client_14', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUserType($this->getReference('user_type_client'));
        $user->setAgent($this->getReference('agent_annan_1'));
        $user->setEmail('emma.wade@example.com');
        $user->setPassword('3271a68a0398eade797d427d6dced8ba');
        $user->setFirstName('Emma');
        $user->setLastName('Wade');
        $user->setStreet('Chester Road');
        $user->setHouseNumber('7993');
        $user->setPostcode('HH37 8YQ');
        $user->setCity('Carlisle');
        $user->setCountry('GB');
        $user->setPhone('0763-131-045');
        $user->setActive(false);
        $this->setReference('user_annan_client_15', $user);
        $manager->persist($user);


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
