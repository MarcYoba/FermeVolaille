<?php

namespace App\Entity;

use App\Repository\SuiviRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuiviRepository::class)]
class Suivi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createtAt = null;

    #[ORM\Column]
    private ?int $age = null; // En jours ou semaines

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $temperature = null; // En °C

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $humidite = null; // En %

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $consommationAliment = 0; // En kg

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $consommationEau = 0; // En Litres

    #[ORM\Column]
    private ?int $nombreMorts = 0;

    #[ORM\Column]
    private ?int $reformes = 0; // Sujets écartés/vendus

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observations = null;

    // Effectif au début de la journée/bande (nécessaire pour calculer l'effectif restant)
    #[ORM\Column]
    private ?int $effectifInitial = 0;

    #[ORM\ManyToOne(inversedBy: 'suivis')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'suivis')]
    private ?Bandes $bande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatetAt(): ?\DateTime
    {
        return $this->createtAt;
    }

    public function setCreatetAt(\DateTime $createtAt): static
    {
        $this->createtAt = $createtAt;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;
        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): static
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getHumidite(): ?float
    {
        return $this->humidite;
    }

    public function setHumidite(?float $humidite): static
    {
        $this->humidite = $humidite;
        return $this;
    }

    public function getConsommationAliment(): ?float
    {
        return $this->consommationAliment;
    }

    public function setConsommationAliment(float $consommationAliment): static
    {
        $this->consommationAliment = $consommationAliment;
        return $this;
    }

    public function getConsommationEau(): ?float
    {
        return $this->consommationEau;
    }

    public function setConsommationEau(float $consommationEau): static
    {
        $this->consommationEau = $consommationEau;
        return $this;
    }

    public function getNombreMorts(): ?int
    {
        return $this->nombreMorts;
    }

    public function setNombreMorts(int $nombreMorts): static
    {
        $this->nombreMorts = $nombreMorts;
        return $this;
    }

    public function getReformes(): ?int
    {
        return $this->reformes;
    }

    public function setReformes(int $reformes): static
    {
        $this->reformes = $reformes;
        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): static
    {
        $this->observations = $observations;
        return $this;
    }

    public function getEffectifInitial(): ?int
    {
        return $this->effectifInitial;
    }

    public function setEffectifInitial(int $effectifInitial): static
    {
        $this->effectifInitial = $effectifInitial;
        return $this;
    }

    // =========================================================================
    // CHAMPS CALCULÉS AUTOMATIQUEMENT (Non stockés en BDD pour éviter la redondance)
    // =========================================================================

    /**
     * Calcule l'effectif restant à la fin de la journée
     */
    public function getEffectifRestant(): int
    {
        return $this->effectifInitial - ($this->nombreMorts + $this->reformes);
    }

    /**
     * Calcule la consommation d'aliment moyenne par sujet (en grammes)
     */
    public function getConsommationParSujet(): float
    {
        $effectifMoyen = $this->getEffectifRestant();
        
        if ($effectifMoyen <= 0) {
            return 0.0;
        }

        // Conversion des kg en grammes / effectif
        return round(($this->consommationAliment * 1000) / $effectifMoyen, 2);
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

    public function getBande(): ?Bandes
    {
        return $this->bande;
    }

    public function setBande(?Bandes $bande): static
    {
        $this->bande = $bande;

        return $this;
    }
}
