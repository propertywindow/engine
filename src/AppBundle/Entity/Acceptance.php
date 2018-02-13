<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="acceptance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AcceptanceRepository")
 */
class Acceptance
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="en", type="string", length=255)
     */
    private $en;

    /**
     * @var string
     * @ORM\Column(name="nl", type="string", length=255)
     */
    private $nl;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $en
     *
     * @return Acceptance
     */
    public function setEn(string $en): Acceptance
    {
        $this->en = $en;

        return $this;
    }

    /**
     * @return string
     */
    public function getEn(): string
    {
        return $this->en;
    }

    /**
     * @param string $nl
     *
     * @return Acceptance
     */
    public function setNl(string $nl): Acceptance
    {
        $this->nl = $nl;

        return $this;
    }

    /**
     * @return string
     */
    public function getNl(): string
    {
        return $this->nl;
    }
}
