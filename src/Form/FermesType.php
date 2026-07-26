<?php

namespace App\Form;

use App\Entity\Fermes;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FermesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom de la ferme',
                'attr' => [
                    'placeholder' => 'Entrez le nom de la ferme',
                    'class' => 'form-control',
                ],
            ])
            ->add('localisation', TextType::class,[
                'label' => 'Localisation',
                'attr' => [
                    'placeholder' => 'Entrez la localisation',
                    'class' => 'form-control',
                ],
            ])
            ->add('responsable', TextType::class,[
                'label' => 'Responsable',
                'attr' => [
                    'placeholder' => 'Entrez le nom du responsable',
                    'class' => 'form-control',
                ],
            ])
            ->add('telephone', TextType::class,[
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Entrez le numéro de téléphone',
                    'class' => 'form-control',
                ],
            ])
            ->add('capacite', NumberType::class,[
                'label' => 'Capacité',
                'attr' => [
                    'placeholder' => 'Entrez la capacité',
                    'class' => 'form-control',
                ],
            ])
            ->add('nombreBatiments', NumberType::class,[
                'label' => 'Nombre de bâtiments',
                'attr' => [
                    'placeholder' => 'Entrez le nombre de bâtiments',
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fermes::class,
        ]);
    }
}
