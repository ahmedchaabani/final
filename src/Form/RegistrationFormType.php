<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType; // Ajoutez cette ligne
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('nom', TextType::class) // Nom
            ->add('prenom', TextType::class) // Prénom
            ->add('telephone', TelType::class, ['required' => false]) // Téléphone
            ->add('adresse', TextType::class, ['required' => false])
            ->add('dateInscription', DateTimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(), // Définit la date et heure actuelles par défaut
                'required' => false,
                'disabled' => true, // Rendre le champ non modifiable
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'autocomplete' => 'new-password'
                    ],
                    'constraints' => [
                        new NotBlank(['message' => 'Ce champ est obligatoire']),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Minimum {{ limit }} caractères',
                            'max' => 128
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation',
                    'attr' => ['class' => 'form-control']
                ],
                'error_bubbling' => false // Crucial pour afficher les erreurs au bon endroit
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
