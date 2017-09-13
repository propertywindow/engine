<?php declare(strict_types=1);

namespace LogBundle\DataFixtures\ORM;

use LogBundle\Entity\Activity;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadActivityData
 * @package LogBundle\DataFixtures\ORM
 */
class LoadActivityData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // todo: only in dev environment

        // Annan Properties

        $activity = new Activity();
        $activity->setUser($this->getReference('user_annan_colleague_1'));
        $activity->setAgent($this->getReference('agent_6'));
        $activity->setActionCategory('property');
        $activity->setActionId(1);
        $activity->setActionName('create');
        $activity->setNewValue(
            $this->container->get('jms_serializer')->serialize(
                $this->getReference('property_annan_1'),
                'json'
            )
        );
        $manager->persist($activity);

        $activity = new Activity();
        $activity->setUser($this->getReference('user_annan_colleague_2'));
        $activity->setAgent($this->getReference('agent_6'));
        $activity->setActionCategory('property');
        $activity->setActionId(1);
        $activity->setActionName('create');
        $activity->setNewValue(
            $this->container->get('jms_serializer')->serialize(
                $this->getReference('property_annan_2'),
                'json'
            )
        );
        $manager->persist($activity);

        $activity = new Activity();
        $activity->setUser($this->getReference('user_annan_colleague_3'));
        $activity->setAgent($this->getReference('agent_6'));
        $activity->setActionCategory('property');
        $activity->setActionId(1);
        $activity->setActionName('create');
        $activity->setNewValue(
            $this->container->get('jms_serializer')->serialize(
                $this->getReference('property_annan_3'),
                'json'
            )
        );
        $manager->persist($activity);


        $manager->flush();
    }

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 50;
    }
}
