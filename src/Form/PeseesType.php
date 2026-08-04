<?php

namespace App\Form;

use App\Entity\Bandes;
use App\Entity\Pesees;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeseesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createtAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de la pesée',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ],
            ])
            ->add('nombreSujetsPeses', NumberType::class, [
                'label' => 'Nombre de sujets pesés',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ],
            ])
            ->add('poidsTotalEchantillon', NumberType::class, [
                'label' => 'Poids total de l\'échantillon',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ],
            ])
            ->add('poidsMoyen', NumberType::class, [
                'label' => 'Poids moyen',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ],
            ])
            ->add('gmq', NumberType::class, [
                'label' => 'Gain moyen quotidien',
                'attr'=>
                [
                    'class' => 'form-control control-user',
                ],
            ])
            ->add('bande', EntityType::class, [
                'class' => Bandes::class,
                'choice_label' => 'matricule',
                'attr'=>
                [
                    'class' => 'form-control form-select control-user',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pesees::class,
        ]);
    }
}
