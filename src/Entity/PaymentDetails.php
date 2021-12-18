<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use App\Repository\PaymentDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentDetailsRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class PaymentDetails
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
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amountToSend;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amountToReceive;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $extra = [];

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="paymentDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=ProjectMaster::class, inversedBy="PaymentDetails")
     */
    private $projectMaster;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $paymentDetailDoc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmountToSend(): ?int
    {
        return $this->amountToSend;
    }

    public function setAmountToSend(?int $amountToSend): self
    {
        $this->amountToSend = $amountToSend;

        return $this;
    }

    public function getAmountToReceive(): ?int
    {
        return $this->amountToReceive;
    }

    public function setAmountToReceive(?int $amountToReceive): self
    {
        $this->amountToReceive = $amountToReceive;

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProjectMaster(): ?ProjectMaster
    {
        return $this->projectMaster;
    }

    public function setProjectMaster(?ProjectMaster $projectMaster): self
    {
        $this->projectMaster = $projectMaster;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentDetailDoc()
    {
        return $this->paymentDetailDoc;
    }

    /**
     * @param string $paymentDetailDoc
     * @return $this
     */
    public function setPaymentDetailDoc(string $paymentDetailDoc): self
    {
        $this->paymentDetailDoc = $paymentDetailDoc;

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
