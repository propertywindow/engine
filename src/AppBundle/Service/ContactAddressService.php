<?php
declare(strict_types = 1);

namespace AppBundle\Service;

use AppBundle\Entity\ContactAddress;
use AppBundle\Exceptions\ContactAddressNotFoundException;
use AppBundle\Repository\ContactAddressRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ContactAddress Service
 */
class ContactAddressService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ContactAddressRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(ContactAddress::class);
    }

    /**
     * @return ContactAddress
     * @throws ContactAddressNotFoundException
     */
    public function getAddress(): ContactAddress
    {
        return $this->repository->findById(1);
    }

    /**
     * @param ContactAddress $address
     *
     * @return ContactAddress
     */
    public function createAddress(ContactAddress $address): ContactAddress
    {
        $this->entityManager->persist($address);
        $this->entityManager->flush();

        return $address;
    }

    /**
     * @param ContactAddress $address
     *
     * @return ContactAddress
     */
    public function updateAddress(ContactAddress $address): ContactAddress
    {
        $this->entityManager->flush();

        return $address;
    }
}
