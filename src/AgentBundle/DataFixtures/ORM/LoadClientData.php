<?php declare(strict_types=1);

namespace AgentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AgentBundle\Entity\Client;

/**
 * Class LoadClientData
 * @package AgentBundle\DataFixtures\ORM
 */
class LoadClientData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setUserId(3);
        $client->setTransparency(true);
        $manager->persist($client);

        $manager->flush();
    }
}
