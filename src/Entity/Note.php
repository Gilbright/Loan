<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Note
{
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="notes")
     */
    private $employee;


    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
    * @ORM\Column(type="string", nullable=false)
    */
    private $authorRole;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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
     * @return string
     */
    public function getAuthorRole(): string
    {
        return $this->authorRole;
    }

    /**
     * @param string $authorRole
     * @return $this
     */
    public function setAuthorRole(string $authorRole): self
    {
        $this->authorRole = $authorRole;

        return $this;
    }
}
