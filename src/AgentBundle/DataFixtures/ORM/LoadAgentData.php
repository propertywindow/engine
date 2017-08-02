<?php declare(strict_types=1);

namespace AgentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AgentBundle\Entity\Agent;

/**
 * Class LoadAgentData
 * @package AgentBundle\DataFixtures\ORM
 */
class LoadAgentData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $agent = new Agent();
        $agent->setGroupId(1);
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
        $manager->persist($agent);

        $agent = new Agent();
        $agent->setGroupId(1);
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
        $manager->persist($agent);

        $manager->flush();
    }
}
