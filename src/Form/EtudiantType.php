<?php

namespace App\Form;

use App\Entity\Etudiant;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Data\Provider\CurrencyDataProvider;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        
            ->add('nom', TextType::class, array(
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'votre nom')
            ))
            ->add('prenoms', TextType::class, array(
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'votre prenom')
            ))


            ->add('adresse', TextType::class, array(
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'votre adresse')
            ))
            

            ->add('dateNaiss', DateType::class, array(
                'required'=>true,
                'widget'=> 'single_text',
                'label'=>'Date de naissance',
                'attr'=>array('class'=>'form-control','placeholder'=>'date de naissance')
            ))



            ->add('sexe', ChoiceType::class, [
                'required'=>true,
                'choices'  => [
                    'sexe'=> null,
                    'Masculin' => 'masculin',
                    'Feminin' => 'feminin',
                 
                  
                ],
                'attr'=>array('class'=>'form-control','placeholder'=>'sexe'),
            ])

           
           

            


           

            ->add('user', UserType::class)


            ->add('telephone', TextType::class, array(
                'required'=>true,
                'attr'=>array('class'=>'form-control','placeholder'=>'+228 XX XX XX XX')
            ))



            
            ->add('imageFile', VichImageType::class, array(
                'required'=>false,
                'label'=>'Photo de profil(optionnel)',
                'attr'=>array('class'=>'form-control','placeholder'=>'photo de profil')
                
                
            ))


           

            
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
