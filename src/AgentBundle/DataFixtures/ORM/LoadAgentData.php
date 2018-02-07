<?php
declare(strict_types=1);

namespace AgentBundle\DataFixtures\ORM;

use AgentBundle\Entity\Agent;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadAgentData
 * @package AgentBundle\DataFixtures\ORM
 */
class LoadAgentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_propertywindow'));
        $agent->setOffice('Edinburgh');
        $agent->setStreet('Portobello High Street');
        $agent->setHouseNumber('27');
        $agent->setPostcode('EH15 1DE');
        $agent->setCity('Edinburgh');
        $agent->setCountry('GB');
        $agent->setEmail('info@propertywindow.com');
        $agent->setPhone('01316571666');
        $agent->setPropertyLimit(200);
        $agent->setEspc(false);
        $agent->setArchived(false);
        $this->addReference('agent_propertywindow_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_annan'));
        $agent->setOffice('Edinburgh');
        $agent->setStreet('Portobello High Street');
        $agent->setHouseNumber('229');
        $agent->setPostcode('EH15 2AN');
        $agent->setCity('Edinburgh');
        $agent->setCountry('GB');
        $agent->setEmail('edinburgh@annan.co.uk');
        $agent->setPhone('01316692121');
        $agent->setFax('01316691155');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->addReference('agent_annan_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_annan'));
        $agent->setOffice('East Lothian');
        $agent->setStreet('High Street');
        $agent->setHouseNumber('84');
        $agent->setPostcode('EH21 7BX');
        $agent->setCity('Musselburgh');
        $agent->setCountry('GB');
        $agent->setEmail('lothian@annan.co.uk');
        $agent->setPhone('01316658080');
        $agent->setFax('01316691155');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->addReference('agent_annan_2', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_oliver'));
        $agent->setOffice('Main');
        $agent->setStreet('High Street');
        $agent->setHouseNumber('13');
        $agent->setPostcode('TD9 9DH');
        $agent->setCity('Hawick');
        $agent->setCountry('GB');
        $agent->setEmail('joliver@gandjoliver.co.uk');
        $agent->setPhone('01450372791');
        $agent->setPropertyLimit(500);
        $agent->setEspc(false);
        $agent->setArchived(false);
        $this->addReference('agent_oliver_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_deans'));
        $agent->setOffice('Newington');
        $agent->setStreet('St Patrick Street');
        $agent->setHouseNumber('3');
        $agent->setPostcode('EH8 9ES');
        $agent->setCity('Edinburgh');
        $agent->setCountry('GB');
        $agent->setEmail('newington@deansproperties.co.uk');
        $agent->setPhone('01316671900');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->addReference('agent_deans_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_deans'));
        $agent->setOffice('Corstorphine');
        $agent->setStreet('St Johns Road');
        $agent->setHouseNumber('135-137');
        $agent->setPostcode('EH12 7SB');
        $agent->setCity('Edinburgh');
        $agent->setCountry('GB');
        $agent->setEmail('corstorphine@deansproperties.co.uk');
        $agent->setPhone('01316671900');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->addReference('agent_deans_2', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_deans'));
        $agent->setOffice('South Queensferry');
        $agent->setStreet('High Street');
        $agent->setHouseNumber('31A');
        $agent->setPostcode('EH30 9PP');
        $agent->setCity('Edinburgh');
        $agent->setCountry('GB');
        $agent->setEmail('southqueensferry@deansproperties.co.uk');
        $agent->setPhone('01316671900');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->addReference('agent_deans_3', $agent);
        $manager->persist($agent);


        $manager->flush();
    }
    
    /**
     * @return integer
     */
    public function getOrder()
    {
        return 11;
    }
}
