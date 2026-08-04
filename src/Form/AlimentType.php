<?php

namespace App\Form;

use App\Entity\Aliment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'aliment',
                'attr' => [
                    'placeholder' => 'Ex: Démarrage, Croissance, Finition...',
                    'class' => 'form-control',
                ],
            ])
            ->add('code', TextType::class, [
                'label' => 'Code / Référence',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: ALIM-001',
                    'class' => 'form-control',
                ],
            ])
            ->add('uniteMesure', ChoiceType::class, [
                'label' => 'Unité de mesure',
                'choices' => [
                    'Kilogramme (kg)' => 'kg',
                    'Sac' => 'sac',
                    'Tonne (t)' => 'tonne',
                    'Litre (L)' => 'L',
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('quantiteStock', NumberType::class, [
                'label' => 'Quantité initiale en stock',
                'scale' => 2,
                'attr' => [
                    'placeholder' => '0.00',
                    'step' => '0.1',
                    'class' => 'form-control',
                ],
            ])
            ->add('stockMinimum', NumberType::class, [
                'label' => 'Seuil d\'alerte (Stock Minimum)',
                'scale' => 2,
                'help' => 'Une alerte sera déclenchée si le stock descend sous ce niveau.',
                'attr' => [
                    'placeholder' => '10.00',
                    'step' => '0.1',
                    'class' => 'form-control',
                ],
            ])
            ->add('prixUnitaire', MoneyType::class, [
                'label' => 'Prix unitaire d\'achat',
                'currency' => 'XOF', // Remplacez par 'EUR', 'USD' ou autre selon votre devise
                'scale' => 2,
                'attr' => [
                    'placeholder' => '0.00',
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aliment::class,
        ]);
    }
}
