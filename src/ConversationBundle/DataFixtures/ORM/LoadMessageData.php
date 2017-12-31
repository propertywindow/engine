<?php declare(strict_types=1);

namespace ConversationBundle\DataFixtures\ORM;

use ConversationBundle\Entity\Message;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadMessageData
 * @package ConversationBundle\DataFixtures\ORM
 */
class LoadMessageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $message = new Message();
        $message->setConversation($this->getReference('conversation_1'));
        $message->setAuthor($this->getReference('user_annan_colleague_1'));
        $message->setRecipient($this->getReference('user_annan_colleague_1'));
        $message->setSeen(false);
        $message->setMessage('<h5>This is your space</h5> 
Draft messages, list your to-dos, or keep links and files handy. 
You can also talk to yourself here, but please bear in mind you’ll have to supply both sides of the conversation.');
        $message->setType('message');
        $manager->persist($message);

        $message = new Message();
        $message->setConversation($this->getReference('conversation_2'));
        $message->setAuthor($this->getReference('user_annan_colleague_1'));
        $message->setRecipient($this->getReference('user_annan_colleague_3'));
        $message->setSeen(true);
        $message->setMessage('Hi Jill');
        $message->setType('message');
        $manager->persist($message);

        $message = new Message();
        $message->setConversation($this->getReference('conversation_2'));
        $message->setAuthor($this->getReference('user_annan_colleague_3'));
        $message->setRecipient($this->getReference('user_annan_colleague_1'));
        $message->setSeen(true);
        $message->setMessage('Hi Michael, how are you?');
        $message->setType('message');
        $manager->persist($message);

        $message = new Message();
        $message->setConversation($this->getReference('conversation_2'));
        $message->setAuthor($this->getReference('user_annan_colleague_1'));
        $message->setRecipient($this->getReference('user_annan_colleague_3'));
        $message->setSeen(false);
        $message->setMessage('Great thanks, What time was our meeting?');
        $message->setType('message');
        $manager->persist($message);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 71;
    }
}
