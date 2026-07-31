<?php

namespace App\Form;

use App\Entity\Bandes;
use App\Entity\Batiments;
use App\Entity\Fermes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BandesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class,[
                'label' => 'Matriccule de la bande',
                'attr' => [
                    'placeholder' => 'Entrez le Matricule de la bande',
                    'class' => 'form-control',
                ],
            ])
            ->add('souche', TextType::class,[
                'label' => 'Souche de la bande',
                'attr' => [
                    'placeholder' => 'Souche de la bande',
                    'class' => 'form-control',
                ],
            ])
            ->add('fournisseur', TextType::class,[
                'label' => 'Fournisseur de la bande',
                'attr' => [
                    'placeholder' => 'Fournisseur de la bande',
                    'class' => 'form-control',
                ],
            ])
            ->add('dateMisePlace', DateType::class,[
                'label' => 'Date de Mise en place',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('poussins', NumberType::class,[
                'label' => 'Nombre de Poussin',
                'attr' => [
                    'placeholder' => 'Nombre de Poussin',
                    'class' => 'form-control',
                ],
            ])
            ->add('prix', NumberType::class,[
                'label' => 'Prix du Poussin',
                'attr' => [
                    'placeholder' => 'Prix du Poussin',
                    'class' => 'form-control',
                ],
            ])
            ->add('poids', NumberType::class,[
                'label' => 'Poids du Poussin',
                'attr' => [
                    'placeholder' => 'Poids du Poussin',
                    'class' => 'form-control',
                ],
            ])
            ->add('dateAbattage', DateType::class,[
                'label' => 'Date de Mise en place',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('status',ChoiceType::class,[
                'label'=> 'Status de la bande',
                'attr' => [ 
                    "class" => "form-control form-control-user",
                ],
                'choices' => [
                    "EN COUR" => "EN COUR",
                    "TRANSFERER"=>"TRANSFERER",
                    "EN VENTE"=>"EN VENTE",
                    "TERMINER"=>"TERMINER",
                    "Autre"=> "autre",
                ],
            ])
            ->add('batiments', EntityType::class, [
                'class' => Batiments::class,
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
            'data_class' => Bandes::class,
        ]);
    }
}
