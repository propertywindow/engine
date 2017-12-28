<?php declare(strict_types=1);

namespace ConversationBundle\Repository;

use ConversationBundle\Entity\Email;
use ConversationBundle\Exceptions\EmailNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * EmailRepository
 */
class EmailRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Email
     * @throws EmailNotFoundException
     */
    public function findById(int $id): Email
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new EmailNotFoundException($id);
        }

        /** @var Email $result */
        return $result;
    }
}
