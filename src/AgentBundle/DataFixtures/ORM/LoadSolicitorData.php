<?php
declare(strict_types = 1);

namespace AgentBundle\DataFixtures\ORM;

use AgentBundle\Entity\Agency;
use AgentBundle\Entity\Agent;
use AgentBundle\Entity\Solicitor;
use AppBundle\Entity\ContactAddress;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadSolicitor Data
 */
class LoadSolicitorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var Agent $agent */
        /** @var Agency $agency */
        /** @var ContactAddress $address */

        $solicitor = new Solicitor();
        $agent     = $this->getReference('agent_annan_1');
        $solicitor->setAgent($agent);
        $agency = $this->getReference('agent_annan_agency_1');
        $solicitor->setAgency($agency);
        $solicitor->setName('Gareth Williams');
        $address = $this->getReference('address_annan_solicitor_1');
        $solicitor->setAddress($address);
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
