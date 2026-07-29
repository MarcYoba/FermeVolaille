<?php

namespace App\Form;

use App\Entity\Batiments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BatimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom du bâtiments',
                'attr' => [
                    'placeholder' => 'Entrez le Nom du bâtiments',
                    'class' => 'form-control',
                ],
            ])
            ->add('surface', TextType::class,[
                'label' => 'Surface du bâtiments',
                'attr' => [
                    'placeholder' => 'Entrez la surface du bâtiments',
                    'class' => 'form-control',
                ],
            ])
            ->add('capacite', TextType::class,[
                'label' => 'Capacite du bâtiments',
                'attr' => [
                    'placeholder' => 'Entrez la Capacite du bâtiments',
                    'class' => 'form-control',
                ],
            ])
            ->add('type', TextType::class,[
                'label' => 'Type du bâtiments',
                'attr' => [
                    'placeholder' => 'Entrez le Type du bâtiments',
                    'class' => 'form-control',
                ],
            ])
            ->add('dateContruction', DateType::class,[
                'label' => 'Date de construction',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('etat', TextType::class,[
                'label' => 'Etat du bâtiments',
                'attr' => [
                    'placeholder' => 'Entrez la Etat du bâtiments',
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Batiments::class,
        ]);
    }
}
