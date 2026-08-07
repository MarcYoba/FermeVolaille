<?php

namespace App\Form;

use App\DTO\DelivranceDTO;
use App\Entity\Lot;
use App\Entity\Traitement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DelivranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // 1. Traitement
            ->add('traitement', EntityType::class, [
                'class' => Traitement::class,
                'choice_label' => 'nomTraitement',
                'placeholder' => '-- Choisir un traitement existant --',
                'required' => false,
            ])
            ->add('nouveauTraitementNom', TextType::class, [
                'label' => 'Ou nom du nouveau traitement',
                'required' => false,
            ])
            ->add('descriptionTraitement', TextareaType::class, [
                'label' => 'Posologie / Instructions',
                'required' => false,
            ])

            // 2. Sortie (Lot & Quantité)
            ->add('lot', EntityType::class, [
                'class' => Lot::class,
                'choice_label' => function (Lot $lot) {
                    $med = $lot->getMedicament();
                    $nom = $med ? $med->getNomCommercial() : 'Produit inconnu';
                    return sprintf('%s | Lot: %s | Exp: %s (Stock: %d)', 
                        $nom, 
                        $lot->getId(), 
                        $lot->getDateExpiration()?->format('d/m/Y'),
                        $lot->getQuantiteEnStock()
                    );
                },
                'placeholder' => '-- Sélectionner le lot en stock --',
            ])
            ->add('quantiteSortie', IntegerType::class, ['label' => 'Quantité délivrée'])
            ->add('motifSortie', ChoiceType::class, [
                'choices' => [
                    'Prescription médicale' => 'Prescription',
                    'Vente directe' => 'Vente',
                    'Usage interne' => 'Usage Interne',
                    'Périmé / Rebut' => 'Périmé',
                ],
                'label' => 'Motif de la sortie',
            ])

            // 3. Coût Sanitaire
            ->add('montantBrut', MoneyType::class, ['currency' => 'XAF', 'label' => 'Montant total brut'])
            ->add('partAssurances', MoneyType::class, ['currency' => 'XAF', 'label' => 'Prise en charge Assurances/Mutuelle'])
            ->add('partPatient', MoneyType::class, ['currency' => 'XAF', 'label' => 'Reste à charge patient'])
            ->add('statutPaiement', ChoiceType::class, [
                'choices' => [
                    'Payé' => 'Payé',
                    'En attente' => 'En attente',
                    'Tiers Payant' => 'Tiers Payant',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DelivranceDTO::class,
        ]);
    }
}