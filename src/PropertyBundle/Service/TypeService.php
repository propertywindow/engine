<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Type;
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

        if ($type === null) {
            throw new TypeNotFoundException($id);
        }

        return $type;
    }

    /**
     * @return Type[]
     *
     * @throws \Doctrine\ORM\RuntimeException
     */
    public function listNotifications()
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
}
