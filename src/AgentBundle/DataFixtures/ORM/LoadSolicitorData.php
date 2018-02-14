<?php
declare(strict_types = 1);

namespace AgentBundle\DataFixtures\ORM;

use AgentBundle\Entity\Agency;
use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Solicitor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadSolicitorData
 */
class LoadSolicitorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $solicitor = new Solicitor();
        /** @var Agent $agent */
        $agent = $this->getReference('agent_annan_1');
        $solicitor->setAgent($agent);
        /** @var Agency $agency */
        $agency = $this->getReference('agent_annan_agency_1');
        $solicitor->setAgency($agency);
        $solicitor->setName('Gareth Williams');
        $solicitor->setStreet('Cadzow PlaceLondon road');
        $solicitor->setHouseNumber('19');
        $solicitor->setPostcode('EH7 5SN');
        $solicitor->setCity('Edinburgh');
        $solicitor->setCountry('GB');
        $solicitor->setEmail('info@aikmainbell.co.uk');
        $solicitor->setPhone('0131 661 0015');
        $this->setReference('agent_annan_solicitor_1', $solicitor);
        $manager->persist($solicitor);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 14;
    }
}
