<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use App\Repository\ProjectMasterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectMasterRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class ProjectMaster
{
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Project::class, inversedBy="projectMaster", cascade={"persist", "remove"})
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity=Client::class, mappedBy="projectMasters")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=PaymentDetails::class, mappedBy="projectMaster")
     */
    private $PaymentDetails;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAbandoned;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $evaluation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teamLeadDocId;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $requestId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFinished;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->PaymentDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
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
            $client->addProjectMaster($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        $this->clients->removeElement($client);

        return $this;
    }

    /**
     * @return Collection|PaymentDetails[]
     */
    public function getPaymentDetails(): Collection
    {
        return $this->PaymentDetails;
    }

    public function addPaymentDetail(PaymentDetails $paymentDetail): self
    {
        if (!$this->PaymentDetails->contains($paymentDetail)) {
            $this->PaymentDetails[] = $paymentDetail;
            $paymentDetail->setProjectMaster($this);
        }

        return $this;
    }

    public function removePaymentDetail(PaymentDetails $paymentDetail): self
    {
        if ($this->PaymentDetails->removeElement($paymentDetail)) {
            // set the owning side to null (unless already changed)
            if ($paymentDetail->getProjectMaster() === $this) {
                $paymentDetail->setProjectMaster(null);
            }
        }

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getIsAbandoned(): ?bool
    {
        return $this->isAbandoned;
    }

    public function setIsAbandoned(bool $isAbandoned): self
    {
        $this->isAbandoned = $isAbandoned;

        return $this;
    }

    public function getEvaluation(): ?int
    {
        return $this->evaluation;
    }

    public function setEvaluation(?int $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getTeamLeadDocId(): ?string
    {
        return $this->teamLeadDocId;
    }

    public function setTeamLeadDocId(string $teamLeadDocId): self
    {
        $this->teamLeadDocId = $teamLeadDocId;

        return $this;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function setRequestId(string $requestId): self
    {
        $this->requestId = $requestId;

        return $this;
    }

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }
}
