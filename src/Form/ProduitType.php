<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom du produit',
                'attr' => [
                    'placeholder' => 'Entrez le nom du produit',
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextType::class,[
                'label' => 'Description du produit',
                'attr' => [
                    'placeholder' => 'Description du produit',
                    'class' => 'form-control',
                ],
            ])
            ->add('createtAt', DateType::class,[
                'label' => 'Date du jour',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Description du produit',
                    'class' => 'form-control',
                ],

            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
