<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'nom de entreprise')
        ))

        ->add('secteur', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'secteur activité')
        ))

        ->add('adresse', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre adresse')
        ))

        ->add('telephone', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre contact')
        ))

        ->add('site', TextType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'votre site web')
        ))

        ->add('user', UserType::class)
           

        ->add('description', TextareaType::class, array(
            'required'=>true,
            'attr'=>array('class'=>'form-control','placeholder'=>'description entreprise')
        ))

        ->add('imageFile', VichImageType::class, array(
            'required'=>false,
            'label'=>'logo (optionnel)',
            'attr'=>array('class'=>'form-control','placeholder'=>'logo entreprises')
            
            
        ))
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
