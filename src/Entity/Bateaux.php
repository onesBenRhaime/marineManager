<?php

namespace App\Entity;

use App\Repository\BateauxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BateauxRepository::class)]
class Bateaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Mat = null;

    #[ORM\Column(length: 255)]
    private ?string $port = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $longeur = null;

    #[ORM\Column(length: 255)]
    private ?string $largeur = null;

    #[ORM\Column(length: 255)]
    private ?string $hauteur = null;

    #[ORM\Column]
    private ?int $numserie = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $tonnage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMat(): ?string
    {
        return $this->Mat;
    }

    public function setMat(string $Mat): self
    {
        $this->Mat = $Mat;

        return $this;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function setPort(string $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLongeur(): ?string
    {
        return $this->longeur;
    }

    public function setLongeur(string $longeur): self
    {
        $this->longeur = $longeur;

        return $this;
    }

    public function getLargeur(): ?string
    {
        return $this->largeur;
    }

    public function setLargeur(string $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?string
    {
        return $this->hauteur;
    }

    public function setHauteur(string $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getNumserie(): ?int
    {
        return $this->numserie;
    }

    public function setNumserie(int $numserie): self
    {
        $this->numserie = $numserie;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getTonnage(): ?string
    {
        return $this->tonnage;
    }

    public function setTonnage(string $tonnage): self
    {
        $this->tonnage = $tonnage;

        return $this;
    }
    public function __toString(): string {
        return $this->id;
    }
}
