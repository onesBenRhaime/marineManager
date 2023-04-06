<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $emailAgent = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?AgentMer $idAgent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEmailAgent(): ?string
    {
        return $this->emailAgent;
    }

    public function setEmailAgent(string $emailAgent): self
    {
        $this->emailAgent = $emailAgent;

        return $this;
    }

    public function getIdAgent(): ?AgentMer
    {
        return $this->idAgent;
    }

    public function setIdAgent(?AgentMer $idAgent): self
    {
        $this->idAgent = $idAgent;

        return $this;
    }
    public function __toString(): string {
        return $this->id;
    }
}
