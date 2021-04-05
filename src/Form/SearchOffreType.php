<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SearchOffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        

              
            
            ->add('specialite', EntityType::class, array(
                'class'=>'App\Entity\Specialite',
                'choice_label'=>'nom',
                'expanded'=>false,
                'multiple'=>false,
                'required'=>false,
                'attr'=>array('class'=>'form-control','placeholder'=>'specialite')
            ))

            ->add('mots', SearchType::class, array(
                'required'=>false,
                'attr'=>array('class'=>'form-control','placeholder'=>'entrez un ou plusieurs mots clés pour votre recherche')
            )) 
            

            ->add('recherchez', SubmitType::class, array(
                
                
                
                'attr'=>array('class'=>'btn-primary')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
