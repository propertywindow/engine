<?php declare(strict_types=1);

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
        $agent->setAgentGroup($this->getReference('agent_group_1'));
        $agent->setName('The Agent NL');
        $agent->setStreet('Graafsedijk');
        $agent->setHouseNumber('19');
        $agent->setPostcode('5437 NG');
        $agent->setCity('Beers');
        $agent->setCountry('NL');
        $agent->setEmail('geurtsmarc@hotmail.com');
        $agent->setPhone('0611839156');
        $agent->setPropertyLimit(200);
        $agent->setEspc(false);
        $agent->setArchived(false);
        $this->addReference('agent_1', $agent);
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setAgentGroup($this->getReference('agent_group_1'));
        $agent->setName('The Agent GB');
        $agent->setStreet('Portobello High Street');
        $agent->setHouseNumber('27');
        $agent->setPostcode('EH15 1DE');
        $agent->setCity('Edinburgh');
        $agent->setCountry('GB');
        $agent->setEmail('iain@datacomputerservices.co.uk');
        $agent->setPhone('07947254956');
        $agent->setPropertyLimit(500);
        $agent->setEspc(true);
        $agent->setArchived(false);
        $this->addReference('agent_2', $agent);
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
