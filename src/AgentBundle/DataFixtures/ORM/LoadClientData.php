<?php declare(strict_types=1);

namespace AgentBundle\DataFixtures\ORM;

use AgentBundle\Entity\Client;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadClientData
 * @package AgentBundle\DataFixtures\ORM
 */
class LoadClientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Annan

        $client = new Client();
        $client->setUser($this->getReference('user_annan_client_1'));
        $client->setAgent($this->getReference('agent_6'));
        $client->setTransparency(true);
        $this->addReference('client_annan_1', $client);
        $manager->persist($client);

        $client = new Client();
        $client->setUser($this->getReference('user_annan_client_2'));
        $client->setAgent($this->getReference('agent_6'));
        $client->setTransparency(true);
        $this->addReference('client_annan_2', $client);
        $manager->persist($client);

        $client = new Client();
        $client->setUser($this->getReference('user_annan_client_3'));
        $client->setAgent($this->getReference('agent_6'));
        $client->setTransparency(true);
        $this->addReference('client_annan_3', $client);
        $manager->persist($client);

//        for ($i = 1; $i <= 2; $i++) {
//            $client = new Client();
//            $client->setUser($this->getReference('user_client_'.$i));
//            $client->setAgent($this->getReference('agent_2'));
//            $client->setTransparency(true);
//            $this->addReference('client_'.$i, $client);
//            $manager->persist($client);
//        }
        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 17;
    }
}
