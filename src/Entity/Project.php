<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
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
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $finalAmount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $repaymentDuration;

    /**
     * @ORM\Column(type="integer")
     */
    private $modalityAmount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $modalityPaymentFrequency;

    /**
     * @ORM\Column(type="text")
     */
    private $details;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $extra = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $businessPlanDocUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailsExtraDocUrl;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="project")
     */
    private $notes;

    /**
     * @ORM\OneToOne(targetEntity=ProjectMaster::class, mappedBy="project", cascade={"persist", "remove"})
     */
    private $projectMaster;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getFinalAmount(): ?int
    {
        return $this->finalAmount;
    }

    public function setFinalAmount(?int $finalAmount): self
    {
        $this->finalAmount = $finalAmount;

        return $this;
    }

    public function getRepaymentDuration(): ?string
    {
        return $this->repaymentDuration;
    }

    public function setRepaymentDuration(string $repaymentDuration): self
    {
        $this->repaymentDuration = $repaymentDuration;

        return $this;
    }

    public function getModalityAmount(): ?int
    {
        return $this->modalityAmount;
    }

    public function setModalityAmount(int $modalityAmount): self
    {
        $this->modalityAmount = $modalityAmount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getModalityPaymentFrequency(): ?int
    {
        return $this->modalityPaymentFrequency;
    }

    public function setModalityPaymentFrequency(int $modalityPaymentFrequency): self
    {
        $this->modalityPaymentFrequency = $modalityPaymentFrequency;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

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

    public function getBusinessPlanDocUrl(): ?string
    {
        return $this->businessPlanDocUrl;
    }

    public function setBusinessPlanDocUrl(string $businessPlanDocUrl): self
    {
        $this->businessPlanDocUrl = $businessPlanDocUrl;

        return $this;
    }

    public function getDetailsExtraDocUrl(): ?string
    {
        return $this->detailsExtraDocUrl;
    }

    public function setDetailsExtraDocUrl(?string $detailsExtraDocUrl): self
    {
        $this->detailsExtraDocUrl = $detailsExtraDocUrl;

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

    public function getProjectMaster(): ?ProjectMaster
    {
        return $this->projectMaster;
    }

    public function setProjectMaster(?ProjectMaster $projectMaster): self
    {
        // unset the owning side of the relation if necessary
        if (null === $projectMaster && null !== $this->projectMaster) {
            $this->projectMaster->setProject(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $projectMaster && $projectMaster->getProject() !== $this) {
            $projectMaster->setProject($this);
        }

        $this->projectMaster = $projectMaster;

        return $this;
    }
}
