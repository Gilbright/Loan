<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Employee implements UserInterface
{
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameSurname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $extra;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="employee")
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idPictureLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idDocumentPictureLink;

    /**
     * @ORM\Column(type="string")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;


    /**
     * @ORM\OneToMany(targetEntity=FinanceDetail::class, mappedBy="operationExecutor")
     */
    private $financeDetails;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->financeDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNameSurname(): ?string
    {
        return $this->nameSurname;
    }

    public function setNameSurname(string $nameSurname): self
    {
        $this->nameSurname = $nameSurname;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $note->setEmployee($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEmployee() === $this) {
                $note->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FinanceDetail[]
     */
    public function getFinanceDetails(): Collection
    {
        return $this->financeDetails;
    }

    public function addFinanceDetail(FinanceDetail $financeDetail): self
    {
        if (!$this->financeDetails->contains($financeDetail)) {
            $this->financeDetails[] = $financeDetail;
            $financeDetail->setOperationExecutor($this);
        }

        return $this;
    }

    public function removeFinanceDetail(FinanceDetail $financeDetail): self
    {
        if ($this->financeDetails->removeElement($financeDetail)) {
            // set the owning side to null (unless already changed)
            if ($financeDetail->getOperationExecutor() === $this) {
                $financeDetail->setOperationExecutor(null);
            }
        }

        return $this;
    }

    public function getIdPictureLink(): ?string
    {
        return $this->idPictureLink;
    }

    public function setIdPictureLink(?string $idPictureLink): self
    {
        $this->idPictureLink = $idPictureLink;

        return $this;
    }

    public function getIdDocumentPictureLink(): ?string
    {
        return $this->idDocumentPictureLink;
    }

    public function setIdDocumentPictureLink(?string $idDocumentPictureLink): self
    {
        $this->idDocumentPictureLink = $idDocumentPictureLink;

        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param $gender
     * @return $this
     */
    public function setGender($gender): self
    {
        $this->gender = $gender;

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

}
