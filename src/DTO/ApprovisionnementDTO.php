<?php

// src/DTO/ApprovisionnementDTO.php
namespace App\DTO;

use App\Entity\Fournisseur;
use App\Entity\Medicament;
use Symfony\Component\Validator\Constraints as Assert;

class ApprovisionnementDTO
{
    // Sélection d'un fournisseur existant OU création d'un nouveau
    public ?Fournisseur $fournisseur = null;
    
    #[Assert\Length(max: 150)]
    public ?string $nouveauFournisseurNom = null;

    // Sélection d'un médicament existant OU création d'un nouveau
    public ?Medicament $medicament = null;

    #[Assert\Length(max: 20000)]
    public ?string $nouveauMedicamentNom = null;

    public ?string $forme = null;

    #[Assert\NotBlank(message: "Le prix unitaire est obligatoire.")]
    public ?string $prixUnitaire = null;

    // Informations du Lot et de l'Entrée
    #[Assert\NotBlank(message: "Le numéro de lot est requis.")]
    public ?string $numeroLot = null;

    #[Assert\NotBlank]
    #[Assert\GreaterThan('today', message: "La date d'expiration doit être dans le futur.")]
    public ?\DateTimeInterface $dateExpiration = null;

    #[Assert\NotBlank]
    #[Assert\Positive(message: "La quantité doit être supérieure à 0.")]
    public ?int $quantite = null;

    #[Assert\NotBlank]
    public ?string $prixAchatUnitaire = null;

    public ?string $numeroFacture = null;
}