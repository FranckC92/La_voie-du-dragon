<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            "label" => "Votre prénom",
            "attr" => [
                "placeholder" => "Veuillez saisir votre prénom"
            ]
        ])
        ->add('lastname', TextType::class, [
            "label" => "Votre nom",
            "attr" => [
                "placeholder" => "Veuillez saisir votre nom"
            ]
        ])
        ->add('email', EmailType::class, [
            "label" => "Votre e-mail",
            "attr" => [
                "placeholder" => "Veuillez saisir votre e-mail"
            ]
        ])
        ->add('content', TextareaType::class, [
            "label" => "Votre message",
            "attr" => [
                "placeholder" => "Veuillez saisir votre message"
            ]
        ])
        
        ->add('submit', SubmitType::class, [
            'label' => "Envoyer"
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
