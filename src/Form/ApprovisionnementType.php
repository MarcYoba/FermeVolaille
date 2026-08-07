<?php

// src/Form/ApprovisionnementType.php
namespace App\Form;

use App\DTO\ApprovisionnementDTO;
use App\Entity\Fournisseur;
use App\Entity\Medicament;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApprovisionnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Section Fournisseur
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nomSociete',
                'placeholder' => '-- Choisir un fournisseur existant --',
                'required' => false,
            ])
            ->add('nouveauFournisseurNom', TextType::class, [
                'label' => 'Ou nom du nouveau fournisseur',
                'required' => false,
            ])

            // Section Médicament
            ->add('medicament', EntityType::class, [
                'class' => Medicament::class,
                'choice_label' => 'nomCommercial',
                'placeholder' => '-- Choisir un médicament existant --',
                'required' => false,
            ])
            ->add('nouveauMedicamentNom', TextType::class, [
                'label' => 'Ou nom du nouveau médicament',
                'required' => false,
            ])
            ->add('forme', TextType::class, ['required' => false, 'label' => 'Forme (ex: Comprimé)'])
            ->add('prixUnitaire', MoneyType::class, ['currency' => 'XAF', 'required' => false])

            // Section Lot & Entrée
            ->add('numeroLot', TextType::class, ['label' => 'N° de Lot'])
            ->add('dateExpiration', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'expiration'
            ])
            ->add('quantite', IntegerType::class, ['label' => 'Quantité reçue'])
            ->add('prixAchatUnitaire', MoneyType::class, ['currency' => 'XAF', 'label' => 'Prix d\'achat unitaire'])
            ->add('numeroFacture', TextType::class, ['required' => false, 'label' => 'N° Facture']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApprovisionnementDTO::class,
        ]);
    }
}
