<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', NumberType::class,[
                'label' => 'Quantite du produit',
                'attr' => [
                    'placeholder' => 'Quantite du produit',
                    'class' => 'form-control',
                ],
            ])
            ->add('prix', NumberType::class,[
                'label' => 'Prix du produit',
                'attr' => [
                    'placeholder' => 'Prix du produit',
                    'class' => 'form-control',
                ],
            ])
            ->add('montant', NumberType::class,[
                'label' => 'Montant du produit',
                'attr' => [
                    'placeholder' => 'Mnontant du produit',
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
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
