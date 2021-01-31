<?php

namespace App\Entity;

use App\Repository\OperationLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationLogRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class OperationLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $hashArrayBefore = [];

    /**
     * @ORM\Column(type="array")
     */
    private $hashArrayAfter = [];

    /**
     * @ORM\Column(type="text")
     */
    private $extra;

    /**
     * @ORM\Column(type="json")
     */
    private $operationExecutor = [];

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHashArrayBefore(): ?array
    {
        return $this->hashArrayBefore;
    }

    public function setHashArrayBefore(array $hashArrayBefore): self
    {
        $this->hashArrayBefore = $hashArrayBefore;

        return $this;
    }

    public function getHashArrayAfter(): ?array
    {
        return $this->hashArrayAfter;
    }

    public function setHashArrayAfter(array $hashArrayAfter): self
    {
        $this->hashArrayAfter = $hashArrayAfter;

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

    public function getOperationExecutor(): ?array
    {
        return $this->operationExecutor;
    }

    public function setOperationExecutor(array $operationExecutor): self
    {
        $this->operationExecutor = $operationExecutor;

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
}
