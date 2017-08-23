<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Type;
use PropertyBundle\Exceptions\TypeDeleteException;
use PropertyBundle\Exceptions\TypeNotFoundException;

/**
 * @package PropertyBundle\Service
 */
class TypeService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Type $type
     *
     * @throws TypeNotFoundException
     */
    public function getType(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Type');
        $type       = $repository->find($id);

        /** @var Type $type */
        if ($type === null) {
            throw new TypeNotFoundException($id);
        }

        return $type;
    }

    /**
     * @return Type[]
     */
    public function getTypes()
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Type');

        return $repository->listAll();
    }

    /**
     * @param Type $type
     *
     * @return Type
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createType(Type $type)
    {
        $this->entityManager->persist($type);
        $this->entityManager->flush();

        return $type;
    }

    /**
     * @param Type $type
     *
     * @return Type
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateType(Type $type)
    {
        $this->entityManager->flush();

        return $type;
    }

    /**
     * @param int $id
     *
     * @throws TypeDeleteException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteType(int $id)
    {
        $typeRepository    = $this->entityManager->getRepository('PropertyBundle:Type');
        $type              = $typeRepository->findById($id);
        $subTypeRepository = $this->entityManager->getRepository('PropertyBundle:SubType');
        $subTypes          = $subTypeRepository->listAll($type->getId());

        if (!empty($subTypes)) {
            throw new TypeDeleteException($id);
        }

        $this->entityManager->remove($type);
        $this->entityManager->flush();
    }
}
