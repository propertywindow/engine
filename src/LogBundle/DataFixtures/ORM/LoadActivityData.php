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
        // Annan Properties

        $propertyService = $this->container->get('PropertyBundle\Service\PropertyService');

        for ($i = 1; $i <= 15; $i++) {
            $activity = new Activity();
            $property = $propertyService->getProperty($i);
            $activity->setUser($this->getReference('user_annan_colleague_'.rand(1, 6)));
            $activity->setAgent($property->getAgent());
            $activity->setActionCategory('property');
            $activity->setActionId(1);
            $activity->setActionName('create');
            $activity->setNewValue(
                $this->container->get('jms_serializer')->serialize(
                    $this->getReference('property_annan_'.$i),
                    'json'
                )
            );
            $manager->persist($activity);
        }

        // Annan Users

        for ($i = 1; $i <= 6; $i++) {
            $activity = new Activity();
            $activity->setUser($this->getReference('user_annan_colleague_'.rand(1, 6)));
            $activity->setAgent($activity->getUser()->getAgent());
            $activity->setActionCategory('user');
            $activity->setActionId(1);
            $activity->setActionName('create');
            $activity->setNewValue(
                $this->container->get('jms_serializer')->serialize(
                    $this->getReference('user_annan_colleague_'.$i),
                    'json'
                )
            );
            $manager->persist($activity);
        }

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
