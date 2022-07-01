<?php

namespace App\Form;

use App\Entity\Blog;
use App\Classe\Searchblog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchblogType extends AbstractType
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
         ->add('blog', EntityType::class, [
             'label' => false,
             'required' => false,
             'class'=> Blog::class, 
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
            'data_class' => Searchblog::class,
            'method' => 'GET',
            'crsf_protection'=> false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '' ; 
    }
}