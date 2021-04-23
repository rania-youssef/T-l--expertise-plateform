<?php

namespace App\Form;

use App\Entity\Specialiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Nom', TextType::class)
        ->add('Prenom', TextType::class)
        ->add('Email', TextType::class)
        ->add('Adresse', TextType::class)
        ->add('Telephone', TextType::class)
        ->add('nbanneExperience', TextType::class)
        ->add('specialite', ChoiceType::class, array(
              'choices'=>  array(
           'La dermatologie '=>'La dermatologie',
           'La cardiologie'=>'La cardiologie',
           'anesthésiologie'=>'anesthésiologie',
           "L'allergologie ou l'immunologie"=>"L'allergologie ou l'immunologie",
           'La chirurgie'=>'La chirurgie',
           'La gastro-entérologie'=>'La gastro-entérologie'
            ),
        ))
         ->add('photo',FileType::class,[
         'label'=>'Ajouter votre photo',
         'mapped'=> false,
         'required'=>false
           ])
        ->add('experiences', TextType::class)
        ->add('dossier',FileType::class,[
            'label'=>'Ajouter votre dossier ..',
            'mapped'=> false,
            'required'=>false,
            'multiple'=>true
              ])
        ->add('Valider', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialiste::class,
        ]);
    }
}
