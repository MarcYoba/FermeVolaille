<?php

namespace App\Form;

use App\Entity\Bandes;
use App\Entity\Suivi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiviType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createtAt', DateType::class, [
                'label' => 'Date du jour',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la date du jour',
                ],
            ])
            ->add('age', NumberType::class, [
                'label' => 'Âge (en jours ou semaines)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'âge en jours ou semaines',
                ],
            ])
            ->add('temperature', NumberType::class, [
                'label' => 'Température (°C)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la température en °C',
                ],
            ])
            ->add('humidite', NumberType::class, [
                'label' => 'Humidité (%)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'humidité en %',
                ],
            ])
            ->add('consommationAliment', NumberType::class, [
                'label' => 'Consommation d\'aliment (kg)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la consommation d\'aliment en kg',
                ],
            ])
            ->add('consommationEau', NumberType::class, [
                'label' => 'Consommation d\'eau (L)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la consommation d\'eau en L',
                ],
            ])
            ->add('nombreMorts', NumberType::class, [
                'label' => 'Nombre de morts',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nombre de morts',
                ],
            ])
            ->add('reformes', NumberType::class, [
                'label' => 'Nombre de reformes',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nombre de reformes',
                ],
            ])
            ->add('observations', TextareaType::class, [
                'label' => 'Observations',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez les observations',
                ],
            ])
            ->add('effectifInitial', NumberType::class, [
                'label' => 'Effectif initial',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'effectif initial',
                ],
            ])
            ->add('bande', EntityType::class, [
                'class' => Bandes::class,
                'choice_label' => 'matricule',
                'label' => 'Bande',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suivi::class,
        ]);
    }
}
