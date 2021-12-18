<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use App\Repository\SavingDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SavingDetailsRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class SavingDetails
{
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $paidMonth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $detailDocUrl;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $extra = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="savingDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="savingDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaidMonth(): ?int
    {
        return $this->paidMonth;
    }

    public function setPaidMonth(int $paidMonth): self
    {
        $this->paidMonth = $paidMonth;

        return $this;
    }

    public function getDetailDocUrl(): ?string
    {
        return $this->detailDocUrl;
    }

    public function setDetailDocUrl(string $detailDocUrl): self
    {
        $this->detailDocUrl = $detailDocUrl;

        return $this;
    }

    public function getExtra(): ?array
    {
        return $this->extra;
    }

    public function setExtra(?array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     * @return $this
     */
    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }
}
