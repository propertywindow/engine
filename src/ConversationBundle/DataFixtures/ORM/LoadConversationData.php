<?php declare(strict_types=1);

namespace ConversationBundle\DataFixtures\ORM;

use ConversationBundle\Entity\Conversation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\BadMethodCallException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadConversationData
 * @package ConversationBundle\DataFixtures\ORM
 */
class LoadConversationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $conversation = new Conversation();
        $conversation->setAuthor($this->getReference('user_annan_colleague_1'));
        $conversation->setRecipient($this->getReference('user_annan_colleague_1'));
        $conversation->setUniqueId($conversation->getAuthor()->getId() + $conversation->getRecipient()->getId());
        $this->addReference('conversation_1', $conversation);
        $manager->persist($conversation);

        $conversation = new Conversation();
        $conversation->setAuthor($this->getReference('user_annan_colleague_1'));
        $conversation->setRecipient($this->getReference('user_annan_colleague_3'));
        $conversation->setUniqueId($conversation->getAuthor()->getId() + $conversation->getRecipient()->getId());
        $this->addReference('conversation_2', $conversation);
        $manager->persist($conversation);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 70;
    }
}
