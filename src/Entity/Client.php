<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Client
{
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $monthlyIncome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profession;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $gender;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $balance;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $idDocNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idPictureUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idDocPictureUrl;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isTeamLead;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $extra = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\OneToMany(targetEntity=SavingDetails::class, mappedBy="client")
     */
    private $savingDetails;

    /**
     * @ORM\ManyToMany(targetEntity=ProjectMaster::class, inversedBy="client")
     */
    private $projectMasters;

    public function __construct()
    {
        $this->savingDetails = new ArrayCollection();
        $this->projectMasters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMonthlyIncome(): ?string
    {
        return $this->monthlyIncome;
    }

    public function setMonthlyIncome(string $monthlyIncome): self
    {
        $this->monthlyIncome = $monthlyIncome;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getIdDocNumber(): ?string
    {
        return $this->idDocNumber;
    }

    public function setIdDocNumber(string $idDocNumber): self
    {
        $this->idDocNumber = $idDocNumber;

        return $this;
    }

    public function getIdPictureUrl(): ?string
    {
        return $this->idPictureUrl;
    }

    public function setIdPictureUrl(string $idPictureUrl): self
    {
        $this->idPictureUrl = $idPictureUrl;

        return $this;
    }

    public function getIdDocPictureUrl(): ?string
    {
        return $this->idDocPictureUrl;
    }

    public function setIdDocPictureUrl(string $idDocPictureUrl): self
    {
        $this->idDocPictureUrl = $idDocPictureUrl;

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

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection|SavingDetails[]
     */
    public function getSavingDetails(): Collection
    {
        return $this->savingDetails;
    }

    public function addSavingDetail(SavingDetails $savingDetail): self
    {
        if (!$this->savingDetails->contains($savingDetail)) {
            $this->savingDetails[] = $savingDetail;
            $savingDetail->setClient($this);
        }

        return $this;
    }

    public function removeSavingDetail(SavingDetails $savingDetail): self
    {
        if ($this->savingDetails->removeElement($savingDetail)) {
            // set the owning side to null (unless already changed)
            if ($savingDetail->getClient() === $this) {
                $savingDetail->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectMaster[]
     */
    public function getProjectMasters()
    {
        return $this->projectMasters;
    }

    public function addProjectMaster(ProjectMaster $projectMaster): self
    {
        if (!$this->projectMasters->contains($projectMaster)) {
            $this->projectMasters[] = $projectMaster;
            //$projectMaster->addClient($this);
        }

        return $this;
    }

    public function removeProjectMaster(ProjectMaster $projectMaster): self
    {
        if ($this->projectMasters->removeElement($projectMaster)) {
            $projectMaster->removeClient($this);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTeamLead()
    {
        return $this->isTeamLead;
    }

    /**
     * @param bool $isTeamLead
     * @return $this
     */
    public function setIsTeamLead(bool $isTeamLead): self
    {
        $this->isTeamLead = $isTeamLead;

        return $this;
    }
}
