<?php
declare(strict_types = 1);

namespace AgentBundle\DataFixtures\ORM;

use AgentBundle\Entity\Agent;
use AgentBundle\Entity\AgentGroup;
use AppBundle\Entity\ContactAddress;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadAgent Data
 */
class LoadAgentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var AgentGroup $agentGroup */
        /** @var ContactAddress $address */

        $agent = new Agent();
        $agentGroup = $this->getReference('agent_group_propertywindow');
        $agent->setAgentGroup($agentGroup);
        $agent->setOffice('Edinburgh');
        $address = $this->getReference('address_agent_propertywindow_1');
        $agent->setAddress($address);
        $agent->setEmail('info@propertywindow.com');
        $agent->setPhone('01316571666');
        $agent->setPropertyLimit(200);
        $agent->setEspc(false);
        $agent->setArchived(false);
        $this->setReference('agent_propertywindow_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agentGroup = $this->getReference('agent_group_annan');
        $agent->setAgentGroup($agentGroup);
        $agent->setOffice('Edinburgh');
        $address = $this->getReference('address_agent_annan_1');
        $agent->setAddress($address);
        $agent->setEmail('edinburgh@annan.co.uk');
        $agent->setPhone('01316692121');
        $agent->setFax('01316691155');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->setReference('agent_annan_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agentGroup = $this->getReference('agent_group_annan');
        $agent->setAgentGroup($agentGroup);
        $agent->setOffice('East Lothian');
        $address = $this->getReference('address_agent_annan_2');
        $agent->setAddress($address);
        $agent->setEmail('lothian@annan.co.uk');
        $agent->setPhone('01316658080');
        $agent->setFax('01316691155');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->setReference('agent_annan_2', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agentGroup = $this->getReference('agent_group_oliver');
        $agent->setAgentGroup($agentGroup);
        $agent->setOffice('Main');
        $address = $this->getReference('address_agent_oliver_1');
        $agent->setAddress($address);
        $agent->setEmail('joliver@gandjoliver.co.uk');
        $agent->setPhone('01450372791');
        $agent->setPropertyLimit(500);
        $agent->setEspc(false);
        $agent->setArchived(false);
        $this->setReference('agent_oliver_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agentGroup = $this->getReference('agent_group_deans');
        $agent->setAgentGroup($agentGroup);
        $agent->setOffice('Newington');
        $address = $this->getReference('address_agent_deans_1');
        $agent->setAddress($address);
        $agent->setEmail('newington@deansproperties.co.uk');
        $agent->setPhone('01316671900');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->setReference('agent_deans_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agentGroup = $this->getReference('agent_group_deans');
        $agent->setAgentGroup($agentGroup);
        $agent->setOffice('Corstorphine');
        $address = $this->getReference('address_agent_deans_2');
        $agent->setAddress($address);
        $agent->setEmail('corstorphine@deansproperties.co.uk');
        $agent->setPhone('01316671900');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->setReference('agent_deans_2', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agentGroup = $this->getReference('agent_group_deans');
        $agent->setAgentGroup($agentGroup);
        $agent->setOffice('South Queensferry');
        $address = $this->getReference('address_agent_deans_3');
        $agent->setAddress($address);
        $agent->setEmail('southqueensferry@deansproperties.co.uk');
        $agent->setPhone('01316671900');
        $agent->setPropertyLimit(100);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->setReference('agent_deans_3', $agent);
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
