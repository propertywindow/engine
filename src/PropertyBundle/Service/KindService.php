<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Kind;

/**
 * @package PropertyBundle\Service
 */
class KindService
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
     * @return Kind $kind
     */
    public function getKind(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Kind');
        $kind       = $repository->findById($id);

        return $kind;
    }

    /**
     * @return Kind[]
     */
    public function getKinds()
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Kind');

        return $repository->findAll();
    }

    /**
     * @param Kind $kind
     *
     * @return Kind
     */
    public function createKind(Kind $kind)
    {
        $this->entityManager->persist($kind);
        $this->entityManager->flush();

        return $kind;
    }

    /**
     * @param Kind $kind
     *
     * @return Kind
     */
    public function updateKind(Kind $kind)
    {
        $this->entityManager->flush();

        return $kind;
    }

    /**
     * @param int $id
     */
    public function deleteKind(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Kind');
        $kind       = $repository->findById($id);

        $this->entityManager->remove($kind);
        $this->entityManager->flush();
    }
}
