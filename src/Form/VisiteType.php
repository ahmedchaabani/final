<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Veterinaire;
use App\Entity\Visite;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('diagnostic')
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'nom',
                'required' => true,
                'placeholder' => 'Sélectionnez un animal'
        
                
            ])
            ->add('veterinaire', EntityType::class, [
                'class' => Veterinaire::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un veterinaire'
            ])
            ->add('dateVisite', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'constraints' => [
                    new Type([
                        'type' => \DateTimeInterface::class,
                        'message' => 'Veuillez entrer une date valide.',
                    ]),
                  ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Date de Visite',
                
            ])
            
            ->add('IdUser', EntityType::class, [
                'class' => User::class, // Target entity
                'choice_label' => 'id', // Display the user's ID in the dropdown
                'label' => 'User', // Custom label
                'placeholder' => 'Select a User', // Optional placeholder
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
