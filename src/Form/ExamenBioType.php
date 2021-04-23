<?php

namespace App\Form;

use App\Entity\ExamenBio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamenBioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('VGM',TextType::class)
            ->add('Hb',ChoiceType::class,array(
                'choices'  => array(
                    '33g' => 33,
                    '66g' => 66,
                    '74g' => 74),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('Images',FileType::class,[
                'label'=>false,
                'multiple'=> true,
                'mapped'=> false,
                'required'=>false
                ])
            ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExamenBio::class,
        ]);
    }
}
