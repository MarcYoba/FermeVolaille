<?php

namespace App\Entity;

use App\Repository\CoutSanitaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoutSanitaireRepository::class)]
class CoutSanitaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'coutSanitaires')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'coutSanitaires')]
    private ?Sortie $sortie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montantBrut = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $partPatient = '0.00';

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getMontantBrut(): ?string
    {
        return $this->montantBrut;
    }

    public function getPartPatient(): ?string
    {
        return $this->partPatient;
    }

    public function setPartPatient(string $partPatient): static
    {
        $this->partPatient = $partPatient;

        return $this;
    }

    public function setMontantBrut(string $montantBrut): static
    {
        $this->montantBrut = $montantBrut;

        return $this;
    }

    public function getSortie(): ?sortie
    {
        return $this->sortie;
    }

    public function setSortie(?sortie $sortie): static
    {
        $this->sortie = $sortie;

        return $this;
    }
}
