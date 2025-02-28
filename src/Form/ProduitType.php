<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Fournisseur;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert; // Correct import for validation constraints

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Nom cannot be empty.']),
                ]
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Description cannot be empty.']),
                ]
            ])
            ->add('prix', NumberType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Prix cannot be empty.']),
                    new Assert\Type(type: 'float', message: 'The price must be a valid number.'),
                    new Assert\Positive(['message' => 'The price must be a positive number.']),
                ]
            ])
            ->add('quantite_stock', NumberType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Quantity cannot be empty.']),
                    new Assert\Type(type: 'float', message: 'The quantity must be a valid number.'),
                    new Assert\Positive(['message' => 'The quantity in stock must be a positive number.']),
                ]
            ])
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Fruits' => 'Fruits',
                    'Légumes' => 'Legumes',
                    'Grains' => 'Grains',
                    'Engrais' => 'Engrais',
                    'Machines' => 'Machines',
                ],
                'expanded' => false, // Dropdown (true for radio buttons)
                'multiple' => false, // Single selection
            ])
            ->add('date_ajout', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nom',  // Assuming 'nom' is a field in Fournisseur
                'placeholder' => 'Select a fournisseur',
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
            'data_class' => Produit::class,
        ]);
    }
}
