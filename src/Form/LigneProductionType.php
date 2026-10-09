<?php

namespace App\Form;

use App\Entity\FicheProduction;
use App\Entity\LigneProduction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LigneProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly', // Empêche l'édition directe dans le tableau
                    ],
            ])
            
            ->add('nom', TextType::class, [ // 👈 Doit être TextType pour afficher uniquement du texte dans le tableau
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => 'readonly', // Empêche l'édition directe dans le tableau
                ],
                'mapped' => false, // Non mappé à l'entité
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneProduction::class,
        ]);
    }
}
