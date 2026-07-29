<?php

namespace App\Form;

use App\Entity\Bloc;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('batiment', TextType::class,[
                'label' => 'Nombre de bâtiments',
                'attr' => [
                    'placeholder' => 'Entrez le nombre de bâtiments',
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextType::class,[
                'label' => 'Nom du bâtiments',
                'attr' => [
                    'placeholder' => 'Nom du Bloc',
                    'class' => 'form-control',
                ],
            ])
            ->add('createtAt', DateType::class,[
                'label' => 'Date du jour',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bloc::class,
        ]);
    }
}
