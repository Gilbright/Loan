<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $projectId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $finalAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $repaymentDuration;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $modalityAmount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $modalityPaymentFrequency;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

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
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="projectId")
     */
    private $clients;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $details;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="project")
     */
    private $notes;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    public function setProjectId(string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getRepaymentDuration(): ?int
    {
        return $this->repaymentDuration;
    }

    public function setRepaymentDuration(int $repaymentDuration): self
    {
        $this->repaymentDuration = $repaymentDuration;

        return $this;
    }

    public function getModalityAmount(): ?float
    {
        return $this->modalityAmount;
    }

    public function setModalityAmount(?float $modalityAmount): self
    {
        $this->modalityAmount = $modalityAmount;

        return $this;
    }

    public function getModalityPaymentFrequency(): ?int
    {
        return $this->modalityPaymentFrequency;
    }

    public function setModalityPaymentFrequency(?int $modalityPaymentFrequency): self
    {
        $this->modalityPaymentFrequency = $modalityPaymentFrequency;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setProjectId($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getProjectId() === $this) {
                $client->setProjectId(null);
            }
        }

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
     * @param mixed $details
     */
    public function setDetails($details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setProject($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getProject() === $this) {
                $note->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFinalAmount()
    {
        return $this->finalAmount;
    }

    /**
     * @param $finalAmount
     * @return $this
     */
    public function setFinalAmount($finalAmount): self
    {
        $this->finalAmount = $finalAmount;

        return $this;
    }
}
