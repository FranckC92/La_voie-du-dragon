<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            "label" => "Votre prénom",
            'constraints' => new Length([
                'min'=> 2,
                'max'=> 30
            ]),
            "attr" => [
                "placeholder" => "Veuillez saisir votre prénom"
            ]
        ])
        ->add('lastname', TextType::class, [
            "label" => "Votre nom",
            'constraints' => new Length([
                'min'=> 2,
                'max'=> 30
            ]),
            "attr" => [
                "placeholder" => "Veuillez saisir votre nom"
            ]
        ])
        ->add('email', EmailType::class, [
            "label" => "Votre e-mail",
            'constraints' => new Length([
                'min'=> 2,
                'max'=> 60
            ]),
            "attr" => [
                "placeholder" => "Veuillez saisir votre e-mail"
            ]
        ])
        ->add('content', TextareaType::class)
        
        ->add('submit', SubmitType::class, [
            'label' => "S'inscrire"
        ])
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
