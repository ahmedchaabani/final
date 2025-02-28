<?php

namespace App\Form;

use App\Entity\Analyse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;


class AnalyseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeE', ChoiceType::class, [
                'choices' => [
                    'Sol' => 'sol',
                    'Eau' => 'eau',
                    'Plante' => 'plante',
                    'Animal' => 'animal',
                ],
                'placeholder' => 'Select a type',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('result', TextType::class, [
                'attr' => ['placeholder' => 'Entrer le résultat doit être entre 10 et 100 caractères']
            ])
            ->add('date_performed', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker',
                    'placeholder' => 'yyyy-MM-dd',
                    'min' => (new \DateTime())->format('Y-m-d'), // Prevent past dates in HTML
],
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
            'data_class' => Analyse::class,
        ]);
    }
}