<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use App\Repository\SavingDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SavingDetailRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class SavingDetail
{
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paidMonth;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $extra;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailDocumentLink;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="savingDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPaidMonth(): ?string
    {
        return $this->paidMonth;
    }

    public function setPaidMonth(?string $paidMonth): self
    {
        $this->paidMonth = $paidMonth;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setExtra(?string $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function getDetailDocumentLink(): ?string
    {
        return $this->detailDocumentLink;
    }

    public function setDetailDocumentLink(?string $detailDocumentLink): self
    {
        $this->detailDocumentLink = $detailDocumentLink;

        return $this;
    }

    public function getClientId(): ?Client
    {
        return $this->clientId;
    }

    public function setClientId(?Client $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }
}
