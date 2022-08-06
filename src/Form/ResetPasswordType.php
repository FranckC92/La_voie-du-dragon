<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         
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
            'label' => "Mettre à jour mon nouveau mot de passe" ,
            'attr' => [
                'class' => 'btn-block btn-info'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
