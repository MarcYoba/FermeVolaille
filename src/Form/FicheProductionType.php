<?php

namespace App\Form;

use App\Entity\FicheProduction;
use App\Entity\Produit;
use App\Form\LigneProductionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'label' => 'Produit',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('lignes', CollectionType::class, [
                'entry_type' => LigneProductionType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('quantiteTotale', NumberType::class, [
                'label' => 'Quantité Totale',
                'attr' => ['class' => 'form-control', 'readonly' => 'readonly'],
                'required' => true,
                'mapped' => false, // Non mappé à l'entité
            ])
            ->add('quantiteSaisie', NumberType::class, [
                'label' => 'Quantité',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control', 'id' => 'input-quantite', 'placeholder' => 'Ex: 10'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FicheProduction::class,
        ]);
    }
}
