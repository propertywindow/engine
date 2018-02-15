<?php
declare(strict_types = 1);

namespace AppBundle\Repository;

use AppBundle\Entity\ContactAddress;
use AppBundle\Exceptions\ContactAddressNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * ContactAddress Repository
 */
class ContactAddressRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return ContactAddress
     * @throws ContactAddressNotFoundException
     */
    public function findById(int $id): ContactAddress
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ContactAddressNotFoundException();
        }

        /** @var ContactAddress $result */
        return $result;
    }
}
