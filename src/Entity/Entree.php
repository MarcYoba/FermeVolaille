<?php

namespace App\Entity;

use App\Repository\EntreeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntreeRepository::class)]
class Entree
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantiteRecue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEntree = null;

    #[ORM\ManyToOne(inversedBy: 'entrees')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'entrees')]
    private ?Fournisseur $fournisseur = null;

    #[ORM\ManyToOne(inversedBy: 'entrees')]
    private ?Lot $lot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getQuantiteRecue(): ?int
    {
        return $this->quantiteRecue;
    }

    public function setQuantiteRecue(int $quantiteRecue): static
    {
        $this->quantiteRecue = $quantiteRecue;

        return $this;
    }

    public function getDateEntree() : ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): static
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getLot(): ?lot
    {
        return $this->lot;
    }

    public function setLot(?lot $lot): static
    {
        $this->lot = $lot;

        return $this;
    }
}
