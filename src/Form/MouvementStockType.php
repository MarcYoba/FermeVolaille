<?php

namespace App\Form;

use App\Entity\Aliment;
use App\Entity\Bandes;
use App\Entity\MouvementStock;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MouvementStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'label' => 'Date de l\'opération',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ]
            ])
            ->add('aliment', EntityType::class, [
                'class' => Aliment::class,
                'choice_label' => 'nom',
                'placeholder' => '-- Choisir un aliment --',
                'label' => 'Aliment concerné',
                'attr'=>
                [
                    'class' => 'form-control form-select control-user',
                ]
            ])
            ->add('typeMouvement', ChoiceType::class, [
                'choices' => [
                    'Entrée en stock (Achat)' => MouvementStock::TYPE_ENTREE,
                    'Sortie (Consommation)' => MouvementStock::TYPE_SORTIE,
                    'Transfert' => MouvementStock::TYPE_TRANSFERT,
                    'Ajustement Inventaire' => MouvementStock::TYPE_INVENTAIRE,
                ],
                'label' => 'Type d\'opération',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ]
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité (kg / sacs)',
                'attr' => ['step' => '0.1'],
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ]
            ])
            ->add('prixUnitaireAchat', NumberType::class, [
                'label' => 'Prix Unitaire d\'Achat (optionnel)',
                'required' => false,
                'attr' => ['step' => '0.01'],
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ]
            ])
            ->add('bande', EntityType::class, [
                'class' => Bandes::class,
                'choice_label' => 'matricule',
                'placeholder' => '-- Aucune (Si Entrée/Inventaire) --',
                'required' => false,
                'label' => 'Bande concernée (en cas de sortie)',
                'attr'=>
                [
                    'class' => 'form-control form-select control-user',
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
                'label' => 'Observations / Note',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MouvementStock::class,
        ]);
    }
}
