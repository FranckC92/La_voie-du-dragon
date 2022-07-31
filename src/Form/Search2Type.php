<?php

namespace App\Form;

use App\Classe\Search2;
use App\Entity\Themes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Search2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         ->add('string', TextType::class, [
             'label' => false,
             'required'=>false ,
             'attr' => [
                 'placeholder' => 'Votre recherche ...',
                 'class' => 'form-control-sm'
             ]
         ])
         ->add('themes', EntityType::class, [
             'label' => false,
             'required' => false,
             'class'=> Themes::class, 
             'multiple' => true,
             'expanded' => true
         ])
         ->add('submit', SubmitType::class, [
             'label' => 'Cherchez',
             'attr' => [
                 'class'=> 'btn-block btn-info'
             ]
         ])
         ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search2::class,
            'method' => 'GET',
            'crsf_protection'=> false,
        ]);
    }
    //fonction pour avoir une url propre je renvoie vide
    public function getBlockPrefix()
    {
        return '' ; 
    }
}