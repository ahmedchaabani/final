<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Veterinaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'Le nom est requis.'])],
           ])
            ->add('age', IntegerType::class,[
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'L age est requis.'])],
        'attr' => ['min' => 1, 'placeholder' => 'Entrez l\'âge'],

            ])
            ->add('type', TextType::class,[
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'Le type est requis.'])],

            ])
            ->add('espece', TextType::class,[
                'required' => true,
        'constraints' => [new NotBlank(['message' => 'L espece est requis.'])],

            ])
            ->add('traitement', TextType::class, ['required' => true])
            
            ->add('veterinaire', EntityType::class, [
                'class' => Veterinaire::class,
                'choice_label' => 'nom'
            ]);  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}