<?php

namespace App\DTO;

use App\Entity\Lot;
use App\Entity\Traitement;
use Symfony\Component\Validator\Constraints as Assert;

class DelivranceDTO
{
    // --- SECTION TRAITEMENT ---
    public ?Traitement $traitement = null;

    #[Assert\Length(max: 150)]
    public ?string $nouveauTraitementNom = null;

    public ?string $descriptionTraitement = null;

    // --- SECTION SORTIE DE STOCK ---
    #[Assert\NotNull(message: "Veuillez sélectionner un lot à prélever.")]
    public ?Lot $lot = null;

    #[Assert\NotBlank(message: "La quantité est obligatoire.")]
    #[Assert\Positive(message: "La quantité doit être supérieure à 0.")]
    public ?int $quantiteSortie = 1;

    public string $motifSortie = 'Prescription';

    // --- SECTION COÛT SANITAIRE ---
    #[Assert\NotBlank(message: "Le montant brut est requis.")]
    public ?string $montantBrut = '0.00';

    public ?string $partAssurances = '0.00';

    public ?string $partPatient = '0.00';

    public string $statutPaiement = 'Payé';
}