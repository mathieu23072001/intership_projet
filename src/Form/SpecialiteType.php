<?php

namespace App\Form;

use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            

            ->add('nom', TextType::class, array(
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'votre nom')
            ))

            ->add('color', ColorType::class, array(
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'votre nom')
            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialite::class,
        ]);
    }
}
