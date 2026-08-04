<?php

namespace App\Entity;

use App\Repository\PeseesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeseesRepository::class)]
class Pesees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createtAt = null;

    #[ORM\Column]
    private ?int $nombreSujetsPeses = null;

    // Poids total mesuré de l'échantillon (en kg ou g) pour calculer la moyenne
    #[ORM\Column(type: Types::FLOAT)]
    private ?float $poidsTotalEchantillon = null;

    // Poids individuel moyen mesuré lors de cette pesée (en g ou kg)
    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $poidsMoyen = null;

    // Gain Moyen Quotidien (GMQ en g/jour)
    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $gmq = null;

    // Relation avec la Bande
    #[ORM\ManyToOne(inversedBy: 'pesees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bandes $bande = null;

    #[ORM\ManyToOne(inversedBy: 'pesees')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatetAt(): ?\DateTimeInterface
    {
        return $this->createtAt;
    }

    public function setCreatetAt(\DateTimeInterface $createtAt): static
    {
        $this->createtAt = $createtAt;
        return $this;
    }

    public function getNombreSujetsPeses(): ?int
    {
        return $this->nombreSujetsPeses;
    }

    public function setNombreSujetsPeses(int $nombreSujetsPeses): static
    {
        $this->nombreSujetsPeses = $nombreSujetsPeses;
        return $this;
    }

    public function getPoidsTotalEchantillon(): ?float
    {
        return $this->poidsTotalEchantillon;
    }

    public function setPoidsTotalEchantillon(float $poidsTotalEchantillon): static
    {
        $this->poidsTotalEchantillon = $poidsTotalEchantillon;
        return $this;
    }

    public function getPoidsMoyen(): ?float
    {
        return $this->poidsMoyen;
    }

    public function setPoidsMoyen(?float $poidsMoyen): static
    {
        $this->poidsMoyen = $poidsMoyen;
        return $this;
    }

    public function getGmq(): ?float
    {
        return $this->gmq;
    }

    public function setGmq(?float $gmq): static
    {
        $this->gmq = $gmq;
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

    // =========================================================================
    // METHODES DE CALCUL AUTOMATIQUE
    // =========================================================================

    /**
     * Calcule automatiquement le poids moyen si non renseigné manuellement
     */
    public function calculerPoidsMoyen(): float
    {
        if ($this->nombreSujetsPeses > 0 && $this->poidsTotalEchantillon > 0) {
            return round($this->poidsTotalEchantillon / $this->nombreSujetsPeses, 3);
        }
        return $this->poidsMoyen ?? 0.0;
    }

    /**
     * Calcule l'écart en % par rapport à la valeur standard de la souche
     */
    public function getEcartPourcentage(float $poidsStandard): float
    {
        if ($poidsStandard <= 0) {
            return 0.0;
        }

        $poidsActuel = $this->getPoidsMoyen() ?? $this->calculerPoidsMoyen();
        
        // Formule : ((Poids Réel - Poids Standard) / Poids Standard) * 100
        return round((($poidsActuel - $poidsStandard) / $poidsStandard) * 100, 2);
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
