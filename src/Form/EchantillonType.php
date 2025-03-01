<?php

namespace App\Form;

use App\Entity\Echantillon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class EchantillonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('code_x', TextType::class, [
            'label' => 'Code X',
            'required' => true,
            'attr' => [
                'placeholder' => 'Entrer le Code X',
                'class' => 'form-control'
            ]
        ])
            ->add('type_e', ChoiceType::class, [
                'choices' => [
                    'sol' => 'sol',
                    'eau' => 'eau',
                    'plante' => 'plante',
                    'animal' => 'animal',
                ],
                'placeholder' => 'Select a type',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('collection_date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker',
                    'placeholder' => 'yyyy-MM-dd',
                    'min' => (new \DateTime())->format('Y-m-d'), // Prevent past dates in HTML
            ],
            ])

            ->add('origin')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'in pending' => 'in pending',
                    'in progress' => 'in progress',
                    'complete' => 'complete',
                ],
                'placeholder' => 'Select a Status',
                'expanded' => false,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Echantillon::class,
        ]);
    }
}