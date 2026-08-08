<?php

namespace App\Form;

use App\Entity\Bandes;
use App\Entity\Vaccination;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VaccinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Relation EntityType vers la Bande de poulets
            ->add('bande', EntityType::class, [
                'class' => Bandes::class,
                'choice_label' => function (Bandes $bande) {
                    return sprintf('Bande : %s (Batiment: %s)', $bande->getMatricule(), $bande->getBatiments()->getNom() ?? $bande->getId());
                },
                'placeholder' => '-- Sélectionner la bande concernée --',
                'label' => 'Bande de poulets',
            ])

            // Sélection ou saisie du vaccin
            ->add('vaccin', ChoiceType::class, [
                'choices' => [
                    'Marek (J1)' => 'Marek',
                    'Newcastle / HB1 (J7)' => 'Newcastle HB1',
                    'Gumboro  (J7)' => 'Gumboro',
                    'Gumboro / IBD (J10 - J14)' => 'IBDL',
                    'Bronchite Infectieuse / IB' => 'Bronchite Infectieuse',
                    'Rappel Newcastle + LaSota (J21)' => 'Newcastle LaSota',
                    'Variole Aviaire' => 'Variole Aviaire',
                    'Autre vaccin' => 'Autre',
                ],
                'label' => 'Nom du Vaccin',
            ])

            // Dates de suivi
            ->add('datePrevue', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date prévue',
            ])
            ->add('dateRealisee', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Date réalisée (Optionnel)',
            ])

            // Détails d'administration
            ->add('dose', TextType::class, [
                'required' => false,
                'label' => 'Dose',
                'attr' => ['placeholder' => 'Ex: 1 dose/sujet ou 1000 doses/flacon'],
            ])
            ->add('voieAdministration', ChoiceType::class, [
                'choices' => [
                    'Eau de boisson' => 'Eau de boisson',
                    'Nébulisation / Spray' => 'Nébulisation',
                    'Goutte oculaire' => 'Oculaire',
                    'Injection sous-cutanée' => 'Sous-cutanée',
                    'Injection intramusculaire' => 'Intramusculaire',
                ],
                'required' => false,
                'label' => 'Voie d\'administration',
            ])
            ->add('responsable', TextType::class, [
                'required' => false,
                'label' => 'Responsable / Vétérinaire',
                'attr' => ['placeholder' => 'Ex: Dr. Martin / Agent Jean'],
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Planifié' => 'Planifie',
                    'Effectué' => 'Effectue',
                    'En retard' => 'En retard',
                ],
                'label' => 'Statut initial',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vaccination::class,
        ]);
    }
}
