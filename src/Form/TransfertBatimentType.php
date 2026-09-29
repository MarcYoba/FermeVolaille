<?php

namespace App\Form;

use App\Entity\Bandes;
use App\Entity\Batiments;
use App\Entity\Bloc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransfertBatimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', IntegerType::class, [
                'label' => 'Quantité',
                'attr' => ['min' => 1, 'placeholder' => 'Entrez la quantité'],
            ])
            ->add('batimenta', EntityType::class, [
                'class' => Batiments::class,
                'choice_label' => 'nom', // Remplacez 'nom' par l'attribut à afficher
                'label' => 'Bâtiment de départ',
                'placeholder' => 'Sélectionnez le bâtiment de départ',
            ])
            ->add('batimentB', EntityType::class, [
                'class' => Batiments::class,
                'choice_label' => 'nom',
                'label' => 'Bâtiment de destination',
                'placeholder' => 'Sélectionnez le bâtiment d\'arrivée',
            ])
            ->add('bloc', EntityType::class, [
                'class' => Bloc::class,
                'choice_label' => 'description',
                'label' => 'Bloc',
                'placeholder' => 'Sélectionnez le bloc',
            ])
            ->add('bandes', EntityType::class, [
                'class' => Bandes::class,
                'choice_label' => 'matricule',
                'label' => 'Bande',
                'placeholder' => 'Sélectionnez la bande',
            ])
            ->add('createtAt', TypeDateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création',
                'data' => new \DateTime(), // Valeur par défaut : aujourd'hui
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => 'EN_ATTENTE',
                    'Validé' => 'VALIDE',
                    'Annulé' => 'ANNULE',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
