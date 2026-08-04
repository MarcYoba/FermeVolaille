<?php

namespace App\Entity;

use App\Repository\AlimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AlimentRepository::class)]
class Aliment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null; // Ex: Démarrage, Croissance, Finition

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $code = null; // Code référence / Lot

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $quantiteStock = 0.0; // En Kg ou Sacs

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $stockMinimum = 10.0; // Seuil de déclenchement d'alerte

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $prixUnitaire = 0.0; // Prix moyen d'achat au Kg/Sac

    #[ORM\Column(length: 20)]
    private ?string $uniteMesure = 'kg'; // 'kg', 'sac', 'tonne'

    #[ORM\OneToMany(mappedBy: 'aliment', targetEntity: MouvementStock::class, orphanRemoval: true)]
    private Collection $mouvements;

    #[ORM\ManyToOne(inversedBy: 'aliments')]
    private ?User $user = null;

    public function __construct()
    {
        $this->mouvements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string 
    { 
        return $this->nom; 
    }
    public function setNom(string $nom): static 
    { 
        $this->nom = $nom; return $this; 
    }

    public function getCode(): ?string 
    { 
        return $this->code; 
    }
    public function setCode(?string $code): static 
    { 
        $this->code = $code; return $this; 
    }

    public function getQuantiteStock(): ?float 
    { 
        return $this->quantiteStock; 
    }
    public function setQuantiteStock(float $quantiteStock): static 
    { 
        $this->quantiteStock = $quantiteStock; 
        return $this; 
    }

    public function getStockMinimum(): ?float 
    { 
        return $this->stockMinimum; 
    }
    public function setStockMinimum(float $stockMinimum): static 
    { 
        $this->stockMinimum = $stockMinimum; 
        return $this; 
    }

    public function getPrixUnitaire(): ?float 
    { 
        return $this->prixUnitaire; 
    }
    public function setPrixUnitaire(float $prixUnitaire): static 
    { 
        $this->prixUnitaire = $prixUnitaire; 
        return $this; 
    }

    public function getUniteMesure(): ?string 
    { 
        return $this->uniteMesure; 
    }
    public function setUniteMesure(string $uniteMesure): static 
    { 
        $this->uniteMesure = $uniteMesure; 
        return $this; 
    }

    /**
     * @return Collection<int, MouvementStock>
     */
    public function getMouvements(): Collection { return $this->mouvements; }

    // =========================================================================
    // MÉTHODES MÉTIER (Alertes & Valeur)
    // =========================================================================

    /**
     * Vérifie si le stock est en dessous du niveau d'alerte
     */
    public function isAlerteStock(): bool
    {
        return $this->quantiteStock <= $this->stockMinimum;
    }

    /**
     * Calcule la valeur totale en stock pour cet aliment
     */
    public function getValeurStockTotal(): float
    {
        return round($this->quantiteStock * $this->prixUnitaire, 2);
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
