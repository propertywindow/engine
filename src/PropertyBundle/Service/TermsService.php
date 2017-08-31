<?php declare(strict_types=1);

namespace PropertyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use PropertyBundle\Entity\Terms;

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
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Terms $term
     */
    public function getTerm(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Terms');
        $term       = $repository->findById($id);

        return $term;
    }

    /**
     * @return Terms[]
     */
    public function getTerms()
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Terms');

        return $repository->findAll();
    }

    /**
     * @param Terms $term
     *
     * @return Terms
     */
    public function createTerm(Terms $term)
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
    public function updateTerm(Terms $term)
    {
        $this->entityManager->flush();

        return $term;
    }

    /**
     * @param int $id
     */
    public function deleteTerm(int $id)
    {
        $repository = $this->entityManager->getRepository('PropertyBundle:Terms');
        $term       = $repository->findById($id);

        $this->entityManager->remove($term);
        $this->entityManager->flush();
    }
}
