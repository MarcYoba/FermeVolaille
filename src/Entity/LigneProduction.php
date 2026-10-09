<?php

namespace App\Entity;

use App\Repository\LigneProductionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneProductionRepository::class)]
class LigneProduction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'float')]
    private ?float $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'lignes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FicheProduction $ficheProduction = null;

    #[ORM\ManyToOne(inversedBy: 'ligneProductions')]
    private ?Produit $produit = null;

    public function getId(): ?int { return $this->id; }

    public function getQuantite(): ?float { return $this->quantite; }
    public function setQuantite(float $quantite): self { $this->quantite = $quantite; return $this; }

    public function getFicheProduction(): ?FicheProduction { return $this->ficheProduction; }
    public function setFicheProduction(?FicheProduction $ficheProduction): self { $this->ficheProduction = $ficheProduction; return $this; }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

}
