<?php

namespace App\Entity;

use App\Repository\MouvementStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MouvementStockRepository::class)]
class MouvementStock
{
    // Types de mouvements possibles
    public const TYPE_ENTREE = 'ENTREE';           // Achat / Réception
    public const TYPE_SORTIE = 'SORTIE';           // Consommation par une bande
    public const TYPE_TRANSFERT = 'TRANSFERT';     // Déplacement vers un autre bâtiment/site
    public const TYPE_INVENTAIRE = 'INVENTAIRE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 20)]
    private ?string $typeMouvement = null; // ENTREE, SORTIE, TRANSFERT, INVENTAIRE

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $quantite = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $prixUnitaireAchat = null; // Pour mettre à jour le coût moyen lors d'une entrée

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null; // Motif de transfert / référence facture

    // Aliment concerné
    #[ORM\ManyToOne(inversedBy: 'mouvements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aliment $aliment = null;

    // Bande liée (Optionnelle: uniquement en cas de SORTIE pour calculer la consommation par bande)
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Bandes $bande = null;

    #[ORM\ManyToOne(inversedBy: 'mouvementStocks')]
    private ?User $user = null;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface { return $this->date; }
    public function setDate(\DateTimeInterface $date): static 
    { 
        $this->date = $date; 
        return $this;
    }

    public function getTypeMouvement(): ?string 
    { 
        return $this->typeMouvement; 
    }
    public function setTypeMouvement(string $typeMouvement): static 
    { 
        $this->typeMouvement = $typeMouvement; 
        return $this; 
    }

    public function getQuantite(): ?float 
    { 
        return $this->quantite; 
    }
    public function setQuantite(float $quantite): static 
    { 
        $this->quantite = $quantite; 
        return $this; 
    }

    public function getPrixUnitaireAchat(): ?float 
    { 
        return $this->prixUnitaireAchat; 
    }
    public function setPrixUnitaireAchat(?float $prixUnitaireAchat): static 
    { 
        $this->prixUnitaireAchat = $prixUnitaireAchat; 
        return $this; 
    }

    public function getCommentaire(): ?string 
    { 
        return $this->commentaire; 
    }
    public function setCommentaire(?string $commentaire): static 
    { 
        $this->commentaire = $commentaire; 
        return $this; 
    }

    public function getAliment(): ?Aliment 
    { 
        return $this->aliment; 
    }
    public function setAliment(?Aliment $aliment): static 
    { 
        $this->aliment = $aliment; 
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

    /**
     * Calcule le coût financier total généré par ce mouvement
     */
    public function getCoutTotal(): float
    {
        $prix = $this->prixUnitaireAchat ?? $this->aliment?->getPrixUnitaire() ?? 0.0;
        return round($this->quantite * $prix, 2);
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
