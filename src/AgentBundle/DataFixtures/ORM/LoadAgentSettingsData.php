<?php declare(strict_types=1);

namespace AgentBundle\DataFixtures\ORM;

use AgentBundle\Entity\AgentSettings;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadAgentSettingsData
 * @package AgentBundle\DataFixtures\ORM
 */
class LoadAgentSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $agentSettings = new AgentSettings();
        $agentSettings->setAgent($this->getReference('agent_propertywindow_1'));
        $agentSettings->setLanguage('en');
        $agentSettings->setCurrency('GBP');
        $agentSettings->setEmailName('Property Window');
        $agentSettings->setEmailAddress('no-reply@propertywindow.nl');
        $agentSettings->setIMAPAddress('imap.gmail.com');
        $agentSettings->setIMAPPort(993);
        $agentSettings->setIMAPSecure('SSL');
        $agentSettings->setIMAPUsername('propertywindownl');
        $agentSettings->setIMAPPassword('PropertyWindow12');
        $agentSettings->setSMTPAddress('smtp.gmail.com');
        $agentSettings->setSMTPPort(465);
        $agentSettings->setSMTPSecure('SSL');
        $agentSettings->setSMTPUsername('propertywindownl');
        $agentSettings->setSMTPPassword('PropertyWindow12');
        $manager->persist($agentSettings);

        $agentSettings = new AgentSettings();
        $agentSettings->setAgent($this->getReference('agent_annan_1'));
        $agentSettings->setLanguage('en');
        $agentSettings->setCurrency('GBP');
        $manager->persist($agentSettings);

        $agentSettings = new AgentSettings();
        $agentSettings->setAgent($this->getReference('agent_annan_2'));
        $agentSettings->setLanguage('en');
        $agentSettings->setCurrency('GBP');
        $manager->persist($agentSettings);

        $agentSettings = new AgentSettings();
        $agentSettings->setAgent($this->getReference('agent_oliver_1'));
        $agentSettings->setLanguage('en');
        $agentSettings->setCurrency('GBP');
        $manager->persist($agentSettings);

        $agentSettings = new AgentSettings();
        $agentSettings->setAgent($this->getReference('agent_deans_1'));
        $agentSettings->setLanguage('en');
        $agentSettings->setCurrency('GBP');
        $manager->persist($agentSettings);

        $agentSettings = new AgentSettings();
        $agentSettings->setAgent($this->getReference('agent_deans_2'));
        $agentSettings->setLanguage('en');
        $agentSettings->setCurrency('GBP');
        $manager->persist($agentSettings);

        $agentSettings = new AgentSettings();
        $agentSettings->setAgent($this->getReference('agent_deans_3'));
        $agentSettings->setLanguage('en');
        $agentSettings->setCurrency('GBP');
        $manager->persist($agentSettings);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 12;
    }
}
