<?php

namespace App\Entity;

use App\Repository\VaccinationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VaccinationRepository::class)]
class Vaccination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $vaccin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datePrevue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRealisee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $responsable = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $dose = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $voieAdministration = null; // Ex: Eau de boisson, Nebulisation, Oculaire, Injection

    #[ORM\Column(length: 50)]
    private ?string $statut = 'Planifié'; // Valeurs possibles : 'Planifié', 'Effectué', 'En retard'

    #[ORM\ManyToOne(inversedBy: 'vaccinations')]
    private ?Bandes $bande = null;

    #[ORM\ManyToOne(inversedBy: 'vaccinations')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVaccin(): ?string
    {
        return $this->vaccin;
    }

    public function setVaccin(string $vaccin): static
    {
        $this->vaccin = $vaccin;
        return $this;
    }

    public function getDatePrevue(): ?\DateTimeInterface
    {
        return $this->datePrevue;
    }

    public function setDatePrevue(\DateTimeInterface $datePrevue): static
    {
        $this->datePrevue = $datePrevue;
        return $this;
    }

    public function getDateRealisee(): ?\DateTimeInterface
    {
        return $this->dateRealisee;
    }

    public function setDateRealisee(?\DateTimeInterface $dateRealisee): static
    {
        $this->dateRealisee = $dateRealisee;
        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(?string $responsable): static
    {
        $this->responsable = $responsable;
        return $this;
    }

    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose(?string $dose): static
    {
        $this->dose = $dose;
        return $this;
    }

    public function getVoieAdministration(): ?string
    {
        return $this->voieAdministration;
    }

    public function setVoieAdministration(?string $voieAdministration): static
    {
        $this->voieAdministration = $voieAdministration;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * Méthode utilitaire pour vérifier si le vaccin est en retard
     */
    public function isEnRetard(): bool
    {
        if ($this->statut === 'Effectué' || $this->dateRealisee !== null) {
            return false;
        }

        return $this->datePrevue < new \DateTime('today');
    }

    public function getBande(): ?Bandes
    {
        return $this->bande;
    }

    public function setBande(?Bandes $bande): static
    {
        $this->bande = $bande;

        return $this;
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
}
