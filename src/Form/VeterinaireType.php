<?php

namespace App\Form;

use App\Entity\Veterinaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class VeterinaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'Le nom est requis.'])],
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'Le prenom est requis.'])],
            ])
            ->add('specialite', TextType::class, [
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'La specialite est requise.'])],
            ])
            ->add('telephone', TelType::class, [
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'Le numero de tel est requis.'])],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'Email@exemple.com'])],
            ])
            ->add('disponibilite', ChoiceType::class, [
                'choices' => [
                'Oui' => 'oui',
                'Non' => 'non',
            ],
            'expanded' => true,  
            'multiple' => false, 
            'constraints' => [
                new Assert\Choice([
                    'choices' => ['oui', 'non'],
                    'message' => "Veuillez choisir 'Oui' ou 'Non'.",
                ]),
            ],
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'Oui, Non'])],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Veterinaire::class, 
        ]);
    }
}
