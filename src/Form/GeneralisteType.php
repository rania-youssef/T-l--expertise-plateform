<?php

namespace App\Form;

use App\Entity\Generaliste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneralisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Nom', TextType::class)
        ->add('Prenom', TextType::class)
        ->add('Email', TextType::class)
        ->add('Adresse', TextType::class)
        ->add('Telephone', TextType::class)
        ->add('nbExperience', TextType::class)
        ->add('photo',FileType::class,[
            'label'=>'Ajouter votre photo..',
            'mapped'=> false,
            'required'=>false
              ])
        ->add('dossier',FileType::class,[
            'label'=>'Ajouter votre dossier ..',
            'mapped'=> false,
            'required'=>false,
            'multiple'=>true
              ])
         ->add('rpps', TextType::class)

        ->add('Envoyer', SubmitType::class, ['label' => 'Envoyer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Generaliste::class,
        ]);
    }
}
