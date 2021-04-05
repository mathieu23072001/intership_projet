<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder



        ->add('specialite', EntityType::class, array(
            'class'=>'App\Entity\Specialite',
            'choice_label'=>'nom',
            'expanded'=>false,
            'multiple'=>false,
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'specialite')
        ))

        
        ->add('titre', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'titre du stage')
        ))


        ->add('langage', TextType::class, array(
            'required'=>false,
            'attr'=>array('class'=>'form-control','placeholder'=>'lanagage à utiliser')
        ))


        ->add('description', TextAreaType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'décrire le projet')
        ))

        
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
