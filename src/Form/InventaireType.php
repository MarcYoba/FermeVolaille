<?php

namespace App\Form;

use App\Entity\Inventaire;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', IntegerType::class, [
            'label' => 'Quantité',
            'attr' => [
                'class' => 'form-control',
                'min' => 1,
                'placeholder' => 'Entrez la quantité...'
            ]
        ])
        ->add('createtAt', DateType::class, [
            'label' => 'Date d\'enregistrement',
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('recherche', TextType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Rechercher un produit',
            'attr' => [
                'class' => 'form-control form-control-lg mb-3',
                'placeholder' => 'Tapez pour rechercher...',
                'id' => 'recherche',
                'onkeyup' => 'Inventaire()' // 👈 Appel de votre fonction JS ici
            ]
        ])
        ->add('produit', EntityType::class, [
            'class' => Produit::class,
            'choice_label' => 'nom', // 👈 Remplacé 'id' par 'nom' (changez 'nom' selon la propriété de votre entité Produit, ex: 'libelle')
            'label' => 'Produit',
            'placeholder' => 'Choisissez un produit...',
            'attr' => [
                'class' => 'form-control',
                'size' => 5,
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inventaire::class,
        ]);
    }
}
