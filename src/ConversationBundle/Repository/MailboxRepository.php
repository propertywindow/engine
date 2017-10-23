<?php declare(strict_types=1);

namespace ConversationBundle\Repository;

use ConversationBundle\Entity\Mailbox;
use ConversationBundle\Exceptions\MailboxNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * MailboxRepository
 */
class MailboxRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Mailbox
     * @throws MailboxNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): Mailbox
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new MailboxNotFoundException($id);
        }

        /** @var Mailbox $result */
        return $result;
    }
}
