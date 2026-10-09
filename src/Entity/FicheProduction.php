<?php

namespace App\Entity;

use App\Repository\FicheProductionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; // <-- Correction de l'import ici
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheProductionRepository::class)]
class FicheProduction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'ficheProduction', targetEntity: LigneProduction::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $lignes;

    #[ORM\ManyToOne(inversedBy: 'ficheProductions')]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'ficheProductions')]
    private ?User $user = null;

    public function __construct()
    {
        $this->lignes = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }

    public function getCreatedAt(): ?\DateTimeInterface 
    { 
        return $this->createdAt; 
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /** @return Collection<int, LigneProduction> */
    public function getLignes(): Collection { return $this->lignes; }

    public function addLigne(LigneProduction $ligne): self
    {
        if (!$this->lignes->contains($ligne)) {
            $this->lignes->add($ligne);
            $ligne->setFicheProduction($this);
        }
        return $this;
    }

    public function removeLigne(LigneProduction $ligne): self
    {
        if ($this->lignes->removeElement($ligne)) {
            if ($ligne->getFicheProduction() === $this) {
                $ligne->setFicheProduction(null);
            }
        }
        return $this;
    }

    public function getTotalQuantite(): float
    {
        $total = 0;
        foreach ($this->lignes as $ligne) {
            $total += $ligne->getQuantite() ?? 0;
        }
        return $total;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

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