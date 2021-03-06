<?php

namespace App\Entity;

use App\Repository\FinanceDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FinanceDetailRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class FinanceDetail
{
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
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amountLeftToBeSentByUs;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amountLeftToBePaidToUs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $extra;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectId;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="financeDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operationExecutor;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmountLeftToBeSentByUs(): ?float
    {
        return $this->amountLeftToBeSentByUs;
    }

    public function setAmountLeftToBeSentByUs(?float $amountLeftToBeSentByUs): self
    {
        $this->amountLeftToBeSentByUs = $amountLeftToBeSentByUs;

        return $this;
    }

    public function getAmountLeftToBePaidToUs(): ?float
    {
        return $this->amountLeftToBePaidToUs;
    }

    public function setAmountLeftToBePaidToUs(?float $amountLeftToBePaidToUs): self
    {
        $this->amountLeftToBePaidToUs = $amountLeftToBePaidToUs;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if (null === $this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    public function getProjectId(): ?Project
    {
        return $this->projectId;
    }

    public function setProjectId(?Project $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getOperationExecutor(): ?Employee
    {
        return $this->operationExecutor;
    }

    public function setOperationExecutor(?Employee $operationExecutor): self
    {
        $this->operationExecutor = $operationExecutor;

        return $this;
    }
}
