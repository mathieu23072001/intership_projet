<?php

namespace App\Form;

use App\Entity\Etudiant;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Intl\Data\Provider\CurrencyDataProvider;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class updateEtuType extends AbstractType
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
            ->add('niveau', EntityType::class, array(
                'class'=>'App\Entity\Niveau',
                'choice_label'=>'nom',
                'expanded'=>false,
                'multiple'=>false,
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'niveau')
            ))
            
           
            ->add('langage', TextareaType::class, array(
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'Vos compétences dans le domaine')
            )) ;         


         
            
           
          


            
            /*->add('dateAjout', DateTime::class, array(
                'required'=>true,
                'attr'=>
            ))*/
           
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
