<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'disabled' => true,
            'label' => 'Mon adresse email',
            'constraints' => new Length([
                'min'=> 2,
                'max'=> 60
            ]),
        ])
        
        ->add('firstname', TextType::class, [
            'disabled' => true,
            'label' => 'Mon prénom',
            'constraints' => new Length([
                'min'=> 2,
                'max'=> 30
            ]),
        ])
        ->add('lastname', TextType::class, [
            'disabled' => true,
            'label' => 'Mon Nom',
            'constraints' => new Length([
                'min'=> 2,
                'max'=> 30
            ]),
        ])
        ->add('old_password', PasswordType::class, [
            'mapped' => false,
            'label' => 'Mon mot de passe actuel',
            'constraints' => new Length([
                'min'=> 8,
                'max'=> 30
            ]),
            'attr' => [
                'placeholder' => 'Veuillez saisir votre mot de passe actuel'
            ]
        ])
        ->add('new_password', RepeatedType::class,[
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => 'le mot de passe et la confirmation doivent être identique.',
            'label' => 'Mon nouveau mot de passe',
            'constraints' => new Length([
                'min'=> 8,
                'max'=> 30
            ]),
            'required' => true,
            'first_options' => [
                 'label' => 'Mon nouveau Mot de passe',
                 'constraints' => new Length([
                    'min'=> 8,
                    'max'=> 30
                ]),
                'attr'=> [
                    'placeholder' =>'Merci de saisir votre nouveau mot de passe'
                ]
            ],
            'second_options' => [ 
                'label' => 'Confirmez mon nouveau mot de passe' ,
                'constraints' => new Length([
                    'min'=> 8,
                    'max'=> 30
                ]),
            'attr' => [
                'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
            ]
            ]
        ])
    
        ->add('submit', SubmitType::class, [
            'label' => "Mettre à jour" 
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
