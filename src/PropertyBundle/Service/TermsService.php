<?php
declare(strict_types = 1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Terms;
use PropertyBundle\Exceptions\TermsNotFoundException;
use PropertyBundle\Repository\TermsRepository;

/**
 * @package PropertyBundle\Service
 */
class TermsService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TermsRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Terms::class);
    }

    /**
     * @param int $id
     *
     * @return Terms
     * @throws TermsNotFoundException
     */
    public function getTerm(int $id): Terms
    {
        return $this->repository->findById($id);
    }

    /**
     * @return Terms[]
     */
    public function getTerms(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Terms $term
     *
     * @return Terms
     */
    public function createTerm(Terms $term): Terms
    {
        $this->entityManager->persist($term);
        $this->entityManager->flush();

        return $term;
    }

    /**
     * @param Terms $term
     *
     * @return Terms
     */
    public function updateTerm(Terms $term): Terms
    {
        $this->entityManager->flush();

        return $term;
    }

    /**
     * @param int $id
     *
     * @throws TermsNotFoundException
     */
    public function deleteTerm(int $id)
    {
        $term = $this->repository->findById($id);

        $this->entityManager->remove($term);
        $this->entityManager->flush();
    }
}
