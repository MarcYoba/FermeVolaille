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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('quantiteSortie', NumberType::class, [
                'label' => 'Quantité délivrée',
                'scale' => 2, // 👈 Nombre de décimales autorisées (ex: 0.30, 1.50)
                'html5' => true, // 👈 Permet au champ HTML5 d'accepter les décimales dans le navigateur
                'attr' => [
                    'class' => 'form-control form-control-lg',
                    'step' => '0.01', // 👈 Permet la saisie des décimales dans le navigateur (ex: 0,1 ou 0,01)
                    'placeholder' => 'Ex: 0.3 ou 1.5'
                ]
            ])
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
            // ->add('montantBrut', MoneyType::class, [
            //     'currency' => 'XAF',
            //     'label' => 'Montant total brut',
            //     'attr' => [
            //         'class' => 'form-control form-control-lg',
            //         'placeholder' => 'Ex: 5000'
            //     ]
            // ])
            // ->add('partAssurances', MoneyType::class, [
            //     'currency' => 'XAF',
            //     'label' => 'Prise en charge Assurances/Mutuelle',
            //     'attr' => [
            //         'class' => 'form-control form-control-lg',
            //         'placeholder' => 'Ex: 0'
            //     ]
            // ])
            // ->add('partPatient', MoneyType::class, [
            //     'currency' => 'XAF',
            //     'label' => 'Reste à charge patient',
            //     'attr' => [
            //         'class' => 'form-control form-control-lg',
            //         'placeholder' => 'Ex: 5000'
            //     ]
            // ])
            // ->add('statutPaiement', ChoiceType::class, [
            //     'label' => 'Statut du paiement',
            //     'choices' => [
            //         'Payé' => 'Payé',
            //         'En attente' => 'En attente',
            //         'Tiers Payant' => 'Tiers Payant',
            //     ],
            //     'placeholder' => 'Sélectionnez un statut...',
            //     'attr' => [
            //         'class' => 'form-select form-select-lg' // Note: form-select est recommandé pour les menus déroulants Bootstrap
            //     ]
            // ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DelivranceDTO::class,
        ]);
    }
}