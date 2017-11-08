<?php declare(strict_types=1);

namespace LogBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Traffic;
use LogBundle\Exceptions\TrafficNotFoundException;

/**
 * @package LogBundle\Service
 */
class LogTrafficService
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
     * @return Traffic $activity
     *
     * @throws TrafficNotFoundException
     */
    public function getTraffic(int $id)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Traffic');
        $traffic    = $repository->find($id);

        /** @var Traffic $traffic */
        if ($traffic === null) {
            throw new TrafficNotFoundException($id);
        }

        return $traffic;
    }

    /**
     * @param int         $propertyId
     * @param string      $ip
     * @param string      $browser
     * @param string      $location
     * @param string|null $referrer
     *
     * @return Traffic
     */
    public function createTraffic(
        int $propertyId,
        string $ip,
        string $browser,
        string $location,
        ?string $referrer
    ) {
        $traffic = new Traffic();

        $traffic->setPropertyId($propertyId);
        $traffic->setIp($ip);
        $traffic->setBrowser($browser);
        $traffic->setLocation($location);
        $traffic->setReferrer($referrer);

        $this->entityManager->persist($traffic);
        $this->entityManager->flush();

        return $traffic;
    }
}