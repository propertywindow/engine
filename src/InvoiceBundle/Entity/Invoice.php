<?php
declare(strict_types = 1);

namespace InvoiceBundle\Entity;

use AgentBundle\Entity\Agent;
use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="InvoiceBundle\Repository\InvoiceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Invoice
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    private $agent;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var \DateTime
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var \DateTime $created
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime $updated
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param \AgentBundle\Entity\Agent $agent
     *
     * @return Invoice
     */
    public function setAgent(Agent $agent): Invoice
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return \AgentBundle\Entity\Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @param string $description
     *
     * @return Invoice
     */
    public function setDescription(string $description): Invoice
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param integer $price
     *
     * @return Invoice
     */
    public function setPrice(int $price): Invoice
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param \DateTime $datetime
     *
     * @return Invoice
     */
    public function setDatetime(\DateTime $datetime): Invoice
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}
