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

//        for ($i = 1; $i <= 15; $i++) {
//            $client = new Client();
//            $client->setUser($this->getReference('user_annan_client_' . $i));
//            $client->setAgent($this->getReference('agent_annan_1'));
//            $client->setTransparency(true);
//            $this->addReference('client_annan_' . $i, $client);
//            $manager->persist($client);
//        }
//
//        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 17;
    }
}
