<?php

namespace App\Form;

use App\Entity\ExamenRadio;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamenRadioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bassin',TextType::class,[
                 'label'=>"Motif de consultatio"
            ])
            ->add('images',FileType::class,[
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
            'data_class' => ExamenRadio::class,
        ]);
    }
}
